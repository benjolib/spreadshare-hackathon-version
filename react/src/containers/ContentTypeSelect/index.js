// @flow
import React, { Component } from 'react';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import Select from 'react-select';
import 'react-select/dist/react-select.css';

import { fetchContentType } from './actions';

class ContentTypeSelect extends Component {
  static defaultProps = {
    value: '',
    name: 'contentType[]',
    placeholder: <span>Select type</span>,
  };

  constructor(props) {
    super(props);

    this.state = {
      value: props.value,
    };
  }

  componentWillMount() {
    this.props.fetchContentType();
  }

  selectChanged = value => {
    this.setState({
      value,
    });
  };

  render() {
    return (
      <div>
        <Select
          name={this.props.name}
          multi={false}
          options={this.props.contentType}
          value={this.state.value}
          placeholder={
            this.props.loading ? 'Loading..' : this.props.placeholder
          }
          onChange={this.selectChanged}
        />
      </div>
    );
  }
}

const mapStateToProps = state => ({
  contentType: state.contentType.all,
  loading: state.contentType.isFetching,
});

const mapDispatchToProps = dispatch =>
  bindActionCreators(
    {
      fetchContentType,
    },
    dispatch,
  );

export default connect(mapStateToProps, mapDispatchToProps)(ContentTypeSelect);
