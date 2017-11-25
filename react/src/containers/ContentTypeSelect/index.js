// @flow
import React, { Component } from "react";
import { bindActionCreators } from "redux";
import { connect } from "react-redux";
import Select from "react-select";
import "react-select/dist/react-select.css";

import { fetchContentType } from "./actions";

class ContentTypeSelect extends Component {
  static defaultProps = {
    values: [],
    name: "contentType[]",
    placeholder: <span>Select contentType</span>
  };

  constructor(props) {
    super(props);

    this.state = {
      values: typeof props.values === "string" ? JSON.parse(props.values) : []
    };
  }

  componentWillMount() {
    this.props.fetchContentType();
  }

  selectChanged = values => {
    if (values.length <= 2) {
      this.setState({
        values
      });
    }
  };

  render() {
    return (
      <div>
        <Select
          name={this.props.name}
          multi
          options={this.props.contentType}
          value={this.state.values}
          placeholder={
            this.props.loading ? "Loading.." : this.props.placeholder
          }
          onChange={this.selectChanged}
        />
      </div>
    );
  }
}

const mapStateToProps = state => ({
  contentType: state.contentType.all,
  loading: state.contentType.isFetching
});

const mapDispatchToProps = dispatch =>
  bindActionCreators(
    {
      fetchContentType
    },
    dispatch
  );

export default connect(mapStateToProps, mapDispatchToProps)(ContentTypeSelect);
