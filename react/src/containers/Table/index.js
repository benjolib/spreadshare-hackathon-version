// @flow
import React, { Component } from "react";
import { connect } from "react-redux";
import HandsOnTable from "react-handsontable";
import _ from "lodash/fp";
import TableHeader from "../../components/TableHeader";
import TableMain from "../../components/TableMain";
import TableButton from "../../components/TableButton";
import TableSearch from "../../components/TableSearch";
import TableLoading from "../../components/TableLoading";
import TableError from "../../components/TableError";
import { voteRow, editCell, fetchTable } from "./actions";
import type { ReduxState } from "../../types";
import type { TableDataWrapper, Rows, Votes } from "./types";
import votesRenderer from "../../lib/votesRenderer";
import cellRenderer from "../../lib/cellRenderer";

type Props = {
  id: string, // from server markup
  data: TableDataWrapper,
  fetchTable: typeof fetchTable,
  editCell: typeof editCell,
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

  props: Props;

  updateSearchValue = (e: Event) => {
    if (typeof e.target.value === "string") {
      this.setState({
        searchValue: e.target.value
      });
    }
  };

  contextMenuCallback = (key, options) => {
    const cell = this.hot.hotInstance.getDataAtCell(
      options.start.row,
      options.start.col
    );
    setTimeout(() => {
      if (!_.isEqual(options.start, options.end)) {
        // TODO: either disable edit when more than one cell selected or use better alert
        alert("Select only one cell for edit");
        return;
      }

      if (key === "edit") {
        // TODO: prompt is temporary until i make proper dropdown
        const newValue = prompt("Please type the new value for the cell");

        this.props.editCell(this.props.id, cell.rowId, cell.id, {
          ...cell,
          content: newValue
        });
      } else if (key === "delete") {
        // TODO: confirm is temporary until i make proper dropdown
        const confirmed = window.confirm("Are you sure?");

        if (!confirmed) {
          return;
        }

        this.props.editCell(this.props.id, cell.rowId, cell.id, {
          ...cell,
          content: ""
        });
      }
    });
  };

  hotDataSearchRows = searchValue => (rows: Rows) =>
    rows.filter(
      row =>
        row.content.filter(cell =>
          cell.content.toLowerCase().includes(searchValue.toLowerCase())
        ).length
    );

  hotDataAddVotes = (votes: Votes) => (rows: Rows) =>
    rows.map(row => ({
      ...row,
      content: [
        votes.find(vote => vote.rowId === row.id),
        ...row.content.map(cell => ({ ...cell, rowId: row.id }))
      ]
    }));

  hotDataFlattenRows = (rows: Rows) => rows.map(row => row.content);

  render() {
    if (!this.props.data || this.props.data.loading) {
      return <TableLoading />;
    }

    if (this.props.data.error || !this.props.data.table) {
      return <TableError />;
    }

    console.log(this.props.data);

    const hotData = _.pipe(
      this.hotDataSearchRows(this.state.searchValue),
      this.hotDataAddVotes(this.props.data.table.votes),
      this.hotDataFlattenRows
    );

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
            init={() => {
              // recalculate height after cells render
              setTimeout(() => {
                this.hot.hotInstance.render();
              }, 0);
            }}
            colHeaders={["Votes", ...this.props.data.table.columns]}
            data={hotData(this.props.data.table.rows)}
            columns={col => {
              if (col === 0) {
                return {
                  readOnly: true,
                  renderer: votesRenderer({
                    tableId: this.props.id,
                    voteRow: rowId => this.props.voteRow(this.props.id, rowId)
                  })
                };
              }
              return {
                readOnly: true,
                renderer: cellRenderer()
              };
            }}
            modifyColWidth={width => {
              if (width > 400) {
                return 400;
              }
            }}
            fixedColumnsLeft={1}
            stretchH="all"
            contextMenuCopyPaste
            contextMenu={{
              callback: this.contextMenuCallback,
              items: {
                edit: {
                  name: "Edit"
                },
                delete: {
                  name: "Delete"
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
  editCell,
  voteRow
};

export default connect(mapStateToProps, mapDispatchToProps)(Table);
