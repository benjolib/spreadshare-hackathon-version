// @flow
import React from 'react';
import Select from 'react-select';
import { connect } from 'react-redux';
import { selectTag } from './actions';
import 'react-select/dist/react-select.css';

class TagsSelect extends React.Component {
  static defaultProps = {
    values: [],
    name: 'tags[]',
    placeholder: <span>Select tags</span>,
  };

  constructor(props) {
    super(props);

    this.state = {
      values: typeof props.values === 'string' ? JSON.parse(props.values) : [],
      tags: [
        {
          value: 3,
          label: 'Fundraising',
        },
        {
          value: 7,
          label: 'Funding',
        },
        {
          value: 14,
          label: 'VC',
        },
      ],
    };
  }

  onChange = value => {
    const { dispatch } = this.props;

    this.setState({
      values: value,
    });

    dispatch(selectTag(value));
  };

  render() {
    const options = {
      name: this.props.name,
      placeholder: this.props.placeholder,
      clearable: true,
      multi: true,
      options: this.state.tags,
      value: this.state.values,
      onChange: this.onChange,
    };

    return (
      <Select {...options} />
    );
  }
}

export default connect()(TagsSelect);
