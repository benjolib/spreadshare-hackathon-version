// @flow
import React, { Component } from "react";
import { bindActionCreators } from "redux";
import { connect } from "react-redux";
import TableComponent from "../../components/TableComponent";
import type { TableWrapper } from "./types";

type Props = {
  tableId: string, // from server markup
  data: TableWrapper
};

type State = {};

class Table extends Component<Props, State> {
  render() {
    console.log(this.props);
    return <TableComponent data={this.props.data.table.rows} />;
  }
}

const mapStateToProps = (state, ownProps) => ({
  data: state.tables[ownProps.tableId]
});

const mapDispatchToProps = dispatch => bindActionCreators({}, dispatch);

export default connect(mapStateToProps, mapDispatchToProps)(Table);
