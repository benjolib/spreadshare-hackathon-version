import React from 'react';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import HotTable from 'react-handsontable';

class Table extends React.Component {
  render() {
    // console.log(this.props);
    // TODO: split into some child components
    return (
      <div className="Table">
        <header className="Table__header">
          <button className="Table__header__button"><img src="/assets/icons/sort.svg" /></button>
          <button className="Table__header__button"><img src="/assets/icons/filter.svg" /></button>
          <button className="Table__header__button"><img src="/assets/icons/add.svg" /></button>
          <div className="Table__header__search">
            <button><img src="/assets/icons/search.svg" /></button>
            <input type="text" placeholder="Search Table" />
          </div>
          <button className="Table__header__button"><img src="/assets/icons/eye.svg" /></button>
        </header>
        <main className="Table__main">
          {/* Votes may not need to be seperate after all */}
          {/* <div className="Table__main__votes">Votes</div> */}
          <HotTable
            className="Table__main__HotTable"
            data={this.props.data}
            contextMenu={true}
            colHeaders={['Votes', 'Name', 'Laptop Pocket', 'Luggage Attach', 'Shoulder Padding', 'Front Loading', 'ClamShell', 'Weight Bearing Hip Belt', 'Rain Cover', 'Fits Lowcost Carry-on', 'Dimensions (in)', 'Max Volume (L)', 'Max Range (L)', 'Weight (lbs)', 'Vol. / Lb.', 'Price ($)', 'Price / Vol. / Lb.', 'URL of offical website', 'Review']}
            columns={[
              {
                width: 100,
                sortIndicator:  true
              },
              {},
              {},
              {},
              {},
              {},
              {},
              {},
              {},
              {},
              {},
              {},
              {},
              {},
              {},
              {},
              {},
              {},
              {}
            ]}
            fixedColumnsLeft={1}
            stretchH="all"
          />
        </main>
      </div>
    );
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
