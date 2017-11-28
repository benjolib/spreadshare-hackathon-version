// @flow
import React, { Component } from "react";
import { connect } from "react-redux";
import HandsOnTable from "react-handsontable";
import _ from "lodash/fp";
import __ from "lodash";
import TableHeader from "../../components/TableHeader";
import TableMain from "../../components/TableMain";
import TableButton from "../../components/TableButton";
import TableSearch from "../../components/TableSearch";
import TableLoading from "../../components/TableLoading";
import TableError from "../../components/TableError";
import { addRow, voteRow, editCell, fetchTable } from "./actions";
import type { ReduxState } from "../../types";
import type { TableDataWrapper, Votes, RowsWithVotes } from "./types";
import addButtonRenderer from "../../lib/addButtonRenderer";
import addInputRenderer from "../../lib/addInputRenderer";
import votesRenderer from "../../lib/votesRenderer";
import cellRenderer from "../../lib/cellRenderer";
import TableSortingMenu from "../../components/TableSortingMenu";
import type { Sortings } from "../../components/TableSortingMenu";

type Props = {
  id: string, // from server markup
  data: TableDataWrapper,
  fetchTable: typeof fetchTable,
  editCell: typeof editCell,
  voteRow: typeof voteRow,
  addRow: typeof addRow
};

type State = {
  searchValue: string,
  sortings: Sortings,
  showAdd: boolean,
  addRowDataGetters: Array<Function>
};

class Table extends Component<Props, State> {
  state = {
    searchValue: "",
    sortings: [],
    showSortings: false,
    showFilters: false,
    showAdd: false,
    addRowDataGetters: []
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

  updateTableSortings = (sortings: Sortings) => {
    this.setState({
      sortings
    });
  };

  showSortings = () => {
    this.setState({
      showSortings: true
    });
  };

  hideSortings = () => {
    this.setState({
      showSortings: false
    });
  };

  toggleSortings = () => {
    this.setState({
      showSortings: !this.state.showSortings
    });
  };

  showFilters = () => {
    this.setState({
      showFilters: true
    });
  };

  hideFilters = () => {
    this.setState({
      showFilters: false
    });
  };

  toggleFilters = () => {
    this.setState({
      showFilters: !this.state.showFilters
    });
  };

  showAdd = () => {
    this.setState({
      showAdd: true
    });
    // recalculate height after cells render
    setTimeout(() => {
      this.hot.hotInstance.render();
    }, 0);
  };

  hideAdd = () => {
    this.setState({
      showAdd: false,
      addRowDataGetters: []
    });
  };

  addRow = () => {
    this.props.addRow(
      this.props.id,
      this.state.addRowDataGetters.map(x => x())
    );
    this.hideAdd();
  };

  setupDataGetter = (col: number, dataGetter: Function) => {
    console.log(this.state.addRowDataGetters);
    console.log(col);
    console.log(dataGetter);
    this.setState(prevState => ({
      addRowDataGetters: [
        ...prevState.addRowDataGetters.slice(0, col - 1),
        dataGetter,
        ...prevState.addRowDataGetters.slice(col)
      ]
    }));
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

  hotDataAddVotes = (votes: Votes) => (rows: RowsWithVotes) =>
    rows.map(row => ({
      ...row,
      content: [
        votes.find(vote => vote.rowId === row.id),
        ...row.content.map(cell => ({ ...cell, rowId: row.id }))
      ]
    }));

  hotDataFilters = x => x;

  hotDataSearchRows = searchValue => (rows: RowsWithVotes) =>
    rows.filter(
      row =>
        row.content.filter(
          cell =>
            cell.content
              ? cell.content.toLowerCase().includes(searchValue.toLowerCase())
              : false
        ).length
    );

  hotDataSortings = (colHeaders, sortings: Sortings) => (rows: RowsWithVotes) =>
    __.orderBy(
      rows,
      sortings.map(sorting => row => {
        const i = __.findIndex(colHeaders, x => x === sorting.by);
        const cell = row.content[i];
        if (cell.content) {
          return cell.content;
        } else if (cell.votes) {
          return cell.votes;
        }
        return "";
      }),
      sortings.map(
        sorting => (sorting.direction === "ascending" ? "asc" : "desc")
      )
    );

  hotDataMaybeShowAdd = (colHeaders, showAdd: boolean) => (
    rows: RowsWithVotes
  ) => {
    console.log(showAdd);
    if (showAdd) {
      const rowsWithAdd: RowsWithVotes = [
        {
          id: null,
          content: colHeaders.map((colHeader, i) => "")
        },
        ...rows
      ];
      return rowsWithAdd;
    }
    return rows;
  };

  hotDataFlattenRows = (rows: RowsWithVotes) => rows.map(row => row.content);

  render() {
    if (!this.props.data || this.props.data.loading) {
      return <TableLoading />;
    }

    if (this.props.data.error || !this.props.data.table) {
      return <TableError />;
    }

    console.log(this.props.data);

    const colHeaders = ["Votes", ...this.props.data.table.columns];

    const hotData = _.pipe(
      this.hotDataAddVotes(this.props.data.table.votes),
      this.hotDataFilters,
      this.hotDataSearchRows(this.state.searchValue),
      this.hotDataSortings(colHeaders, this.state.sortings),
      this.hotDataMaybeShowAdd(colHeaders, this.state.showAdd),
      this.hotDataFlattenRows
    );

    return (
      <div>
        <TableHeader>
          <TableButton icon="sort" onClick={this.toggleSortings} />
          <TableButton icon="filter" onClick={this.toggleFilters} />
          <TableButton icon="add" onClick={this.showAdd} />
          <TableSearch onChange={this.updateSearchValue} />
          <TableButton icon="eye" />
        </TableHeader>
        <div style={{ position: "relative" }}>
          <TableSortingMenu
            hide={!this.state.showSortings}
            onApply={this.updateTableSortings}
            colHeaders={colHeaders}
            appliedSortings={this.state.sortings}
          />
        </div>
        <TableMain>
          <HandsOnTable
            ref={ref => (this.hot = ref)}
            init={() => {
              // recalculate height after cells render
              setTimeout(() => {
                this.hot.hotInstance.render();
              }, 0);
            }}
            colHeaders={colHeaders}
            data={hotData(this.props.data.table.rows)}
            cells={(row, col) => {
              if (this.state.showAdd && row === 0) {
                if (col === 0) {
                  return {
                    readOnly: true,
                    renderer: addButtonRenderer({
                      addRow: this.addRow,
                      hideAdd: this.hideAdd
                    })
                  };
                }
                return {
                  readOnly: true,
                  renderer: addInputRenderer({
                    setupDataGetter: this.setupDataGetter
                  })
                };
              }
              if (col === 0) {
                return {
                  readOnly: true,
                  renderer: votesRenderer({
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
            fixedRowsTop={this.state.showAdd ? 1 : 0}
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
  voteRow,
  addRow
};

export default connect(mapStateToProps, mapDispatchToProps)(Table);
