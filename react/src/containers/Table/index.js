// @flow
import React, { Component } from "react";
import { connect } from "react-redux";
import HandsOnTable from "react-handsontable";
import _ from "lodash";
import TableHeader from "../../components/TableHeader";
import TableMain from "../../components/TableMain";
import TableButton from "../../components/TableButton";
import TableSearch from "../../components/TableSearch";
import TableLoading from "../../components/TableLoading";
import TableError from "../../components/TableError";
import { voteRow, editRow, fetchTable } from "./actions";
import type { ReduxState } from "../../types";
import type { TableDataWrapper, Rows } from "./types";
import reactRenderer from "../../lib/reactRenderer";

type Props = {
  id: string, // from server markup
  data: TableDataWrapper,
  fetchTable: typeof fetchTable,
  editRow: typeof editRow,
  voteRow: typeof voteRow
};

type State = {
  searchValue: string
};

class Table extends Component<Props, State> {
  state = {
    searchValue: ""
  };

  state: State;

  componentDidMount() {
    this.props.fetchTable(this.props.id);
  }
  rowIndexMap = {};

  props: Props;

  updateSearchValue = (e: Event) => {
    if (typeof e.target.value === "string") {
      this.setState({
        searchValue: e.target.value
      });
    }
  };

  addVotesColumn = (rows: Rows, votes: Array<string>) =>
    rows.map((row, rowIndex) => [votes[rowIndex], ...row]);

  searchRows = (rows: Rows) =>
    rows
      .map((row, rowIndex) => ({
        rowIndex,
        row
      }))
      .filter(
        row =>
          row.row.filter(field =>
            field.toLowerCase().includes(this.state.searchValue.toLowerCase())
          ).length
      )
      .map((row, rowIndex) => {
        this.rowIndexMap[rowIndex] = row.rowIndex;
        return row.row;
      });

  contextMenuCallback = (key, options) => {
    if (key === "edit") {
      setTimeout(() => {
        // timeout is used to make sure the menu collapsed before prompt is shown
        if (!_.isEqual(options.start, options.end)) {
          // TODO: either disable edit when more than one cell selected or use better alert
          alert("Select only one cell for edit");
          return;
        }

        const cell = options.start;

        // TODO: prompt is temporary until i make proper dropdown
        const newValue = prompt("Please type the new value for the cell");

        console.log(newValue);

        if (typeof newValue !== "string") {
          return;
        }

        const rowData = [
          ...this.props.data.table.rows[this.rowIndexMap[cell.row]].slice(
            0,
            cell.col
          ),
          newValue,
          ...this.props.data.table.rows[this.rowIndexMap[cell.row]].slice(
            cell.col + 1
          )
        ];

        this.props.editRow(this.props.id, this.rowIndexMap[cell.row], rowData);
      }, 100);
    } else if (key === "delete") {
      setTimeout(() => {
        // timeout is used to make sure the menu collapsed before prompt is shown
        if (!_.isEqual(options.start, options.end)) {
          // TODO: either disable edit when more than one cell selected or use better alert
          alert("Select only one cell for delete");
          return;
        }

        const cell = options.start;

        // TODO: confirm is temporary until i make proper dropdown
        const confirmed = window.confirm("Are you sure?");

        if (!confirmed) {
          return;
        }

        const rowData = [
          ...this.props.data[this.props.id].table.rows[
            this.rowIndexMap[cell.row]
          ].slice(0, cell.col),
          "",
          ...this.props.data[this.props.id].table.rows[
            this.rowIndexMap[cell.row]
          ].slice(cell.col + 1)
        ];

        this.props.editRow(this.props.id, this.rowIndexMap[cell.row], rowData);
      }, 100);
    }
  };

  vote = row => {
    this.props.voteRow(this.props.id, this.rowIndexMap[row]);
  };

  render() {
    if (!this.props.data || this.props.data.loading) {
      return <TableLoading />;
    }

    if (this.props.data.error || !this.props.data.table) {
      return <TableError />;
    }

    console.log(this.props.data);

    const rowsWithVotes = this.addVotesColumn(
      this.props.data.table.rows,
      this.props.data.table.votes
    );

    const searchedRows = this.searchRows(rowsWithVotes); // with side effect

    return (
      <div>
        <TableHeader>
          <TableButton icon="sort" />
          <TableButton icon="filter" />
          <TableButton icon="add" />
          <TableSearch onChange={this.updateSearchValue} />
          <TableButton icon="eye" />
        </TableHeader>
        <TableMain>
          <HandsOnTable
            ref={ref => (this.hot = ref)}
            colHeaders={this.props.data.table.columns}
            data={searchedRows}
            columns={this.props.data.table.columns.map(
              (item, i) =>
                i === 0
                  ? {
                      readOnly: true,
                      data: "jsx",
                      renderer: reactRenderer({
                        searchedRows,
                        vote: this.vote
                      }),
                      width: 80
                    }
                  : {
                      readOnly: true
                    }
            )}
            modifyColWidth={width => {
              if (width > 400) {
                return 400;
              }
            }}
            fixedColumnsLeft={1}
            stretchH="last"
            contextMenuCopyPaste
            contextMenu={{
              callback: this.contextMenuCallback,
              items: {
                edit: {
                  name: "Edit"
                },
                delete: {
                  name: "Delete"
                },
                copy: {
                  name: "Copy"
                }
              }
            }}
          />
        </TableMain>
      </div>
    );
  }
}

const mapStateToProps = (state: ReduxState, ownProps: Props) => ({
  data: state.tables[ownProps.id]
});

const mapDispatchToProps = {
  fetchTable,
  editRow,
  voteRow
};

export default connect(mapStateToProps, mapDispatchToProps)(Table);
