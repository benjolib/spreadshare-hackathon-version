// @flow
import React from 'react';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import TableComponent from '../../components/TableComponent';

class Table extends React.Component {
  render() {
    // console.log(this.props);
    return <TableComponent data={this.props.data} />;
  }
}

const mapStateToProps = state => ({
  data: state.table.data,
});

const mapDispatchToProps = dispatch => bindActionCreators({}, dispatch);

export default connect(
  mapStateToProps,
  mapDispatchToProps,
)(Table);
