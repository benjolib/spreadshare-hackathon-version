// @flow
import React, { Component } from "react";
import styled from "styled-components";
import { connect } from "react-redux";
import HandsOnTable from "react-handsontable";
import swal from "sweetalert2";
import _ from "lodash/fp";
import __ from "lodash";
import TableHeader from "../../components/TableHeader";
import TableMain from "../../components/TableMain";
import TableButton from "../../components/TableButton";
import TableSearch from "../../components/TableSearch";
import TableLoading from "../../components/TableLoading";
import TableError from "../../components/TableError";
import {
  addCol,
  editCol,
  addRow,
  voteRow,
  editCell,
  fetchTable,
  deleteRow,
  deleteCol
} from "./actions";
import type { ReduxState } from "../../types";
import type { TableDataWrapper, Votes, RowsWithVotes, Cell } from "./types";
import addButtonRenderer from "../../lib/addButtonRenderer";
import addInputRenderer from "../../lib/addInputRenderer";
import votesRenderer from "../../lib/votesRenderer";
import cellRenderer from "../../lib/cellRenderer";
import TableSortingMenu from "../../components/TableSortingMenu";
import type { Sortings } from "../../components/TableSortingMenu";
// import TableFilterMenu from "../../components/TableFilterMenu";
import type { Filters } from "../../components/TableFilterMenu";
import TableDropdownMenu from "../../components/TableDropdownMenu";
import TableAdminEditInput from "../../components/TableAdminEditInput";
// import $ from "jquery";

const TableStyles = styled.div``;

type Props = {
  id: string, // from server markup
  permission: string,
  data: TableDataWrapper,
  fetchTable: typeof fetchTable,
  editCell: typeof editCell,
  voteRow: typeof voteRow,
  addRow: typeof addRow,
  editCol: typeof editCol,
  addCol: typeof addCol,
  deleteCol: typeof deleteCol,
  deleteRow: typeof deleteRow
};

type State = {
  searchValue: string,
  sortings: Sortings,
  filters: Filters,
  showAdd: boolean,
  showSortings: boolean,
  showFilters: boolean,
  showDropdown: boolean,
  addRowDataGetters: Array<Function>
};

class Table extends Component<Props, State> {
  state = {
    searchValue: "",
    sortings: [],
    filters: [],
    showSortings: false,
    showFilters: false,
    showAdd: false,
    addRowDataGetters: [],
    selectedCell: false
  };

  state: State;

  componentDidMount() {
    this.props.fetchTable(this.props.id);
    // TODO: Commented this out since it broke add row
    // $(document).click(() => this.setState({ showSortings: false }));
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

  updateTableFilters = (filters: Filters) => {
    this.setState({
      filters
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

  toggleSortings = ev => {
    ev.preventDefault();
    ev.stopPropagation();
    ev.nativeEvent.stopImmediatePropagation();

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

  showDropdown = () => {
    this.setState({
      showDropdown: true
    });
  };

  hideDropdown = () => {
    this.setState({
      showDropdown: false
    });
  };

  toggleDropdown = () => {
    this.setState({
      showDropdown: !this.state.showDropdown
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
      showAdd: false
    });
  };

  addRow = () => {
    this.props
      .addRow(
        this.props.id,
        this.state.addRowDataGetters.map(x => x()),
        this.props.permission
      )
      .then(() => {
        this.hideAdd();
        swal({
          title: "Success!",
          type: "success",
          timer: 650,
          showConfirmButton: false
        });
      });
  };

  setupDataGetter = (col: number, dataGetter: Function) => {
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
      // if (!_.isEqual(options.start, options.end)) {
      //   // TODO: either disable edit when more than one cell selected or use better alert
      //   alert("Select only one cell for edit");
      //   return;
      // }

      if (key === "my_delete_row") {
        swal({
          title: "Are you sure?",
          type: "warning",
          text: "Once deleted, you will not be able to recover this row!",
          showLoaderOnConfirm: true,
          showCancelButton: true,
          preConfirm: confirmed => {
            if (!confirmed) {
              return;
            }

            return this.props.deleteRow(this.props.id, cell.rowId);
          }
        })
          .then(result => {
            if (!result.value) {
              return;
            }
            swal({
              title: "Success!",
              type: "success",
              timer: 650,
              showConfirmButton: false
            });
          })
          .catch(() => {
            swal("Oops", "Something has gone wrong!", "error");
          });
      } else if (key === "my_delete_col") {
        swal({
          title: "Are you sure?",
          type: "warning",
          text: "Once deleted, you will not be able to recover this column!",
          showLoaderOnConfirm: true,
          showCancelButton: true,
          preConfirm: confirmed => {
            if (!confirmed) {
              return;
            }

            return this.props.deleteCol(this.props.id, cell.colId);
          }
        })
          .then(result => {
            if (!result.value) {
              return;
            }
            swal({
              title: "Success!",
              type: "success",
              timer: 650,
              showConfirmButton: false
            });
          })
          .catch(() => {
            swal("Oops", "Something has gone wrong!", "error");
          });
      } else if (
        key === "my_insert_col_left" ||
        key === "my_insert_col_right"
      ) {
        let insertBeforeId;
        let insertAfterId;
        if (key === "my_insert_col_left") {
          insertBeforeId = cell.colId;
        } else if (key === "my_insert_col_right") {
          insertAfterId = cell.colId;
        }
        swal({
          title: "What is the title of the new column?",
          input: "text",
          text: "Please type the new column title.",
          showCancelButton: true,
          showLoaderOnConfirm: true,
          preConfirm: newValue => {
            if (typeof newValue !== "string") {
              return;
            }

            return this.props.addCol(
              this.props.id,
              newValue,
              this.props.permission,
              insertBeforeId,
              insertAfterId
            );
          }
        })
          .then(result => {
            if (!result.value) {
              return;
            }
            if (this.props.permission === "1") {
              swal(
                "Success!",
                "The request to add this column is awaiting approval.",
                "success"
              );
            } else if (this.props.permission === "2") {
              swal({
                title: "Success!",
                type: "success",
                timer: 650,
                showConfirmButton: false
              });
            }
          })
          .catch(() => {
            swal("Oops", "Something has gone wrong!", "error");
          });
      } else if (key === "my_add_url") {
        swal({
          title: "Adding URL",
          input: "text",
          text: "Please type the new url for the cell",
          inputValue: cell.link || "",
          showCancelButton: true,
          showLoaderOnConfirm: true,
          preConfirm: newValue => {
            if (!typeof newValue === "string") {
              return;
            }

            return this.props.editCell(
              this.props.id,
              cell.rowId,
              cell.id,
              {
                ...cell,
                link: newValue
              },
              this.props.permission
            );
          }
        })
          .then(result => {
            if (!result.value) {
              return;
            }
            if (this.props.permission === "1") {
              swal(
                "Success!",
                "The request to link this cell is awaiting approval.",
                "success"
              );
            } else if (this.props.permission === "2") {
              swal({
                title: "Success!",
                type: "success",
                timer: 650,
                showConfirmButton: false
              });
            }
          })
          .catch(() => {
            swal("Oops", "Something has gone wrong!", "error");
          });
      } else if (key === "my_edit_col") {
        swal({
          title: "Editing Column Title",
          input: "text",
          text: "Please type the new value for the column title.",
          inputValue: this.props.data.table.columns.find(
            col => (col.id === cell.colId ? col.title : false)
          ).title,
          showCancelButton: true,
          showLoaderOnConfirm: true,
          preConfirm: newValue => {
            if (!typeof newValue === "string") {
              return;
            }

            return this.props.editCol(
              this.props.id,
              cell.colId,
              newValue,
              this.props.permission
            );
          }
        })
          .then(result => {
            if (!result.value) {
              return;
            }
            if (this.props.permission === "1") {
              swal(
                "Success!",
                "The request to edit this column is awaiting approval.",
                "success"
              );
            } else if (this.props.permission === "2") {
              swal({
                title: "Success!",
                type: "success",
                timer: 650,
                showConfirmButton: false
              });
            }
          })
          .catch(() => {
            swal("Oops", "Something has gone wrong!", "error");
          });
      } else if (key === "my_edit") {
        swal({
          title: "Editing Cell",
          input: "text",
          text: "Please type the new value for the cell",
          inputValue: cell.content,
          showCancelButton: true,
          showLoaderOnConfirm: true,
          preConfirm: newValue => {
            if (!typeof newValue === "string") {
              return;
            }

            return this.props.editCell(
              this.props.id,
              cell.rowId,
              cell.id,
              {
                ...cell,
                content: newValue
              },
              this.props.permission,
              cell.content
            );
          }
        })
          .then(result => {
            if (!result.value) {
              return;
            }
            if (this.props.permission === "1" && cell.content) {
              swal(
                "Success!",
                "The request to edit this cell is awaiting approval.",
                "success"
              );
            } else {
              swal({
                title: "Success!",
                type: "success",
                timer: 650,
                showConfirmButton: false
              });
            }
          })
          .catch(() => {
            swal("Oops", "Something has gone wrong!", "error");
          });
      } else if (key === "my_delete") {
        swal({
          title: "Are you sure?",
          type: "warning",
          text: "Once deleted, you will not be able to recover this cell!",
          showLoaderOnConfirm: true,
          showCancelButton: true,
          preConfirm: confirmed => {
            if (!confirmed) {
              return;
            }

            return this.props.editCell(
              this.props.id,
              cell.rowId,
              cell.id,
              {
                ...cell,
                content: "",
                link: ""
              },
              this.props.permission
            );
          }
        })
          .then(result => {
            if (!result.value) {
              return;
            }
            if (this.props.permission === "1") {
              swal(
                "Success!",
                "The request to delete this cell is awaiting approval.",
                "success"
              );
            } else if (this.props.permission === "2") {
              swal({
                title: "Success!",
                type: "success",
                timer: 650,
                showConfirmButton: false
              });
            }
          })
          .catch(() => {
            swal("Oops", "Something has gone wrong!", "error");
          });
      }
    });
  };

  hotDataAddVotes = (columns, votes: Votes) => (rows: RowsWithVotes) =>
    rows.map(row => ({
      ...row,
      content: [
        votes.find(vote => vote.rowId === row.id),
        ...row.content.map((cell, i) => ({
          ...cell,
          rowId: row.id,
          colId: columns[i].id
        }))
      ]
    }));

  hotDataFilters = x => x;

  hotDataSearchRows = searchValue => (rows: RowsWithVotes) =>
    rows.filter(
      row =>
        row.content.filter(
          cell =>
            typeof cell.content === "string"
              ? cell.content.toLowerCase().includes(searchValue.toLowerCase())
              : false
        ).length
    );

  hotDataSortings = (colHeaders, sortings: Sortings) => (rows: RowsWithVotes) =>
    __.orderBy(
      rows,
      [
        ...sortings.map(sorting => row => {
          const i = __.findIndex(colHeaders, x => x === sorting.by);
          const cell = row.content[i];
          if (cell.content) {
            return cell.content;
          } else if (cell.votes) {
            return cell.votes;
          }
          return "";
        }),
        row => row.content[0].votes
      ],
      [
        ...sortings.map(
          sorting => (sorting.direction === "ascending" ? "asc" : "desc")
        ),
        "desc"
      ]
    );

  hotDataMaybeShowAdd = (colHeaders, showAdd: boolean) => (
    rows: RowsWithVotes
  ) => {
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

    const colHeaders = [
      "Votes",
      ...this.props.data.table.columns.map(col => col.title)
    ];

    const hotData = _.pipe(
      this.hotDataAddVotes(
        this.props.data.table.columns,
        this.props.data.table.votes
      ),
      this.hotDataFilters,
      this.hotDataSearchRows(this.state.searchValue),
      this.hotDataSortings(colHeaders, this.state.sortings),
      this.hotDataMaybeShowAdd(colHeaders, this.state.showAdd),
      this.hotDataFlattenRows
    );

    return (
      <TableStyles>
        <TableHeader>
          {this.props.permission === "2" && (
            <TableAdminEditInput
              tableId={this.props.id}
              permission={this.props.permission}
              selectedCell={this.state.selectedCell}
              editCell={this.props.editCell}
            />
          )}
          <TableButton
            icon="sort-white"
            className="table-button sort"
            onClick={ev => this.toggleSortings(ev)}
          >
            Sort Table
          </TableButton>
          {/* <TableButton icon="filter" onClick={this.toggleFilters} /> */}
          {this.props.permission !== "0" && (
            <TableButton
              icon="add-white"
              className="table-button add-row"
              onClick={this.showAdd}
            >
              Add a Row
            </TableButton>
          )}
          <TableSearch onChange={this.updateSearchValue} />
          <TableButton icon="dots" className="" onClick={this.toggleDropdown} />
        </TableHeader>
        <div style={{ position: "relative" }}>
          <TableSortingMenu
            hide={!this.state.showSortings}
            onApply={this.updateTableSortings}
            colHeaders={colHeaders}
            appliedSortings={this.state.sortings}
          />
          {/* <TableFilterMenu
            sortShown={this.state.showSortings}
            hide={!this.state.showFilters}
            onApply={this.updateTableFilters}
            colHeaders={colHeaders}
            appliedFilters={this.state.filters}
          /> */}
          <TableDropdownMenu
            tableId={this.props.id}
            hide={!this.state.showDropdown}
            showAdd={this.showAdd}
            permission={this.props.permission}
            addCol={this.props.addCol}
          />
        </div>
        <TableMain showAdd={this.state.showAdd}>
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
                    voteRow: rowId => this.props.voteRow(this.props.id, rowId),
                    permission: this.props.permission
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
            fixedRowsTop={Number(this.props.data.table.fixedRowsTop) || false}
            fixedColumnsLeft={
              this.props.data.table.fixedColumnsLeft
                ? Number(this.props.data.table.fixedColumnsLeft) + 1
                : 1
            }
            stretchH="all"
            disableVisualSelection={this.state.showAdd}
            afterSelection={(row, col) => {
              if (this.state.showAdd && row === 0) {
                return;
              }
              if (col === 0) {
                return;
              }
              const cell = this.hot.hotInstance.getDataAtCell(row, col);
              if (cell.link) {
                setTimeout(() => {
                  this.setState({
                    selectedCell: cell
                  });
                }, 1000);
              } else {
                this.setState({
                  selectedCell: cell
                });
              }
            }}
            outsideClickDeselects={false}
            contextMenuCopyPaste
            beforeCopy={data => {
              data.forEach((data2, i) => {
                data2.forEach((cellValue, i2) => {
                  // we gotta mutate here
                  // eslint-disable-next-line no-param-reassign
                  data[i][i2] = cellValue.content;
                });
              });
            }}
            contextMenu={{
              callback: this.contextMenuCallback,
              items: {
                ...(this.props.permission === "1" ||
                this.props.permission === "2"
                  ? {
                      my_edit: {
                        name: "Edit Cell"
                      },
                      my_delete: {
                        name: "Clear Cell"
                      },
                      my_add_url: {
                        name: "Edit Cell URL"
                      }
                    }
                  : {}),
                ...(this.props.permission === "2"
                  ? {
                      my_edit_col: {
                        name: "Edit Column Header"
                      },
                      my_insert_col_left: {
                        name: "Insert Column Left"
                      },
                      my_insert_col_right: {
                        name: "Insert Column Right"
                      },
                      my_delete_row: {
                        name: "Delete Row"
                      },
                      my_delete_col: {
                        name: "Delete Column"
                      }
                    }
                  : {}),
                copy: {
                  name: "Copy"
                }
              }
            }}
          />
        </TableMain>
      </TableStyles>
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
  addRow,
  addCol,
  editCol,
  deleteRow,
  deleteCol
};

export default connect(mapStateToProps, mapDispatchToProps)(Table);
