// @flow
import React, { Component } from 'react';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import Select from 'react-select';
import 'react-select/dist/react-select.css';
import { getLocations } from './api';

export const loadLocations = searchTerm => {
  searchTerm = searchTerm.trim();
  if (searchTerm && searchTerm.length >= 2) {
    return getLocations(searchTerm).then(json => ({
      options: json.data,
      complete: true,
    }));
  }

  // Return an empty fake promise
  return Promise.resolve();
};

class LocationSelect extends Component {
  static defaultProps = {
    value: [],
    name: 'location[]',
    placeholder: <span>Select locations</span>,
  };

  constructor(props) {
    super(props);

    // Initial state
    this.state = {
      value: typeof props.value === 'string' ? JSON.parse(props.value) : [],
    };
  }

  componentDidUpdate = (prevProps, prevState) => {
    if (this.state.value) {
      if (this.state.value.length !== prevState.value.length) {
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
      labelKey: 'locationName',
      autofocus: false,
      autoload: false,
      backspaceRemoves: false,
      clearable: true,
      searchable: true,
      placeholder: this.props.placeholder,
      multi: true,
      onChange: this.onChange,
      value: this.state.value,
      loadOptions: loadLocations,
      matchPos: 'start',
    };

    // Add options for preselection
    if (this.state.value) {
      if (options.options.length === 0 && this.state.value.forEach) {
        this.state.value.forEach(item => {
          options.options.push({
            locationName: item.locationName,
            id: item.id,
          });
        });
      }
    }

    return (
      <div>
        <Select.Async {...options} />
      </div>
    );
  }
}

const mapStateToProps = state => ({});

const mapDispatchToProps = dispatch => bindActionCreators({}, dispatch);

export default connect(mapStateToProps, mapDispatchToProps)(LocationSelect);
