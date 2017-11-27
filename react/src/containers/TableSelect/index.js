// @flow
import React, { Component } from 'react';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import Select from 'react-select';
import 'react-select/dist/react-select.css';
import { getTables } from './api';

export const loadTables = searchTerm => {
  searchTerm = searchTerm.trim();
  if (searchTerm && searchTerm.length >= 2) {
    return getTables(searchTerm).then(json => ({
      options: json.data,
      complete: true,
    }));
  }

  // Return an empty fake promise
  return Promise.resolve();
};

class TableSelect extends Component {
  static defaultProps = {
    value: '',
    name: 'tag[]',
    placeholder: <span>Select tables</span>,
  };

  constructor(props) {
    super(props);

    let value = null;
    if (props.value && typeof props.value === 'string') {
      value = JSON.parse(props.value);
      if (!value) {
        value = null;
      }
    }

    // Initial state
    this.state = {
      value,
    };
  }

  componentDidUpdate = (prevProps, prevState) => {
    if (this.state.value) {
      if (this.state.value !== prevState.value) {
        if (this.props.submitFormOnChange) {
          const form = document.getElementById(this.props.submitFormOnChange);
          if (form) {
            form.submit();
          }
        }
      }
    }
  };

  onChange = value => {
    this.setState({
      value,
    });
  };

  render() {
    const options = {
      name: this.props.name,
      options: [],
      valueKey: 'id',
      labelKey: 'title',
      autofocus: false,
      autoload: false,
      backspaceRemoves: false,
      clearable: true,
      searchable: true,
      placeholder: this.props.placeholder,
      multi: false,
      onChange: this.onChange,
      value: this.state.value,
      loadOptions: loadTables,
      matchPos: 'start',
    };

    return (
      <div>
        <Select.Async {...options} />
      </div>
    );
  }
}

const mapStateToProps = state => ({});

const mapDispatchToProps = dispatch => bindActionCreators({}, dispatch);

export default connect(mapStateToProps, mapDispatchToProps)(TableSelect);
