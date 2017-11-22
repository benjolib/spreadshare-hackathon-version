// @flow
import React, { Component } from 'react';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import HandsOnTable from 'react-handsontable';
import TableHeader from '../../components/TableHeader';
import TableMain from '../../components/TableMain';
import TableButton from '../../components/TableButton';
import TableSearch from '../../components/TableSearch';
import TableLoading from '../../components/TableLoading';
import TableError from '../../components/TableError';
import { fetchTable } from './actions';
import type { ReduxState, Dispatch } from '../../types';
import type { TableDataWrapper, Rows } from './types';

type Props = {
  tableId: string, // from server markup
  data: TableDataWrapper,
  fetchTable: typeof fetchTable,
};

type State = {
  search: string,
};

class Table extends Component {
  state: State;

  state = {
    searchValue: '',
  };

  props: Props;

  updateSearchValue = (e: SyntheticInputEvent) => {
    this.setState({
      searchValue: e.target.value,
    });
  };

  searchRows = (rows: Rows) =>
    rows.filter(
      row =>
        row.filter(field =>
          field.toLowerCase().includes(this.state.searchValue.toLowerCase()),
        ).length,
    );

  render() {
    if (this.props.data.loading) {
      return <TableLoading />;
    }

    if (this.props.data.error || !this.props.data.table) {
      return <TableError />;
    }

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
            colHeaders={this.props.data.table.columns}
            data={this.searchRows(this.props.data.table.rows)}
            contextMenu
            stretchH="all"
          />
        </TableMain>
      </div>
    );
  }
}

const mapStateToProps = (state: ReduxState, ownProps: Props) => ({
  data: state.tables[ownProps.tableId],
});

const mapDispatchToProps = {
  fetchTable,
};

export default connect(mapStateToProps, mapDispatchToProps)(Table);
