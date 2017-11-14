import React from 'react';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import HotTable from 'react-handsontable';

class Table extends React.Component {
  render() {
    console.log(this.props);
    return <div>
      <HotTable
        data={this.props.data}
        contextMenu={true}
        colHeaders={true}
      />
    </div>;
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
