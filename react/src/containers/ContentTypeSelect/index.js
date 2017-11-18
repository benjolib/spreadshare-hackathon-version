import React from 'react';
import Select from 'react-select';
import { connect } from 'react-redux';
import { selectType } from './actions';
import 'react-select/dist/react-select.css';

class ContentTypeSelect extends React.Component {
  static defaultProps = {
    value: [],
    name: 'contentType',
    placeholder: <span>Select tags</span>,
  };

  constructor(props) {
    super(props);

    this.state = {
      value: props.value,
      types: [
        {
          value: 'contacts',
          label: 'Contacts',
        },
        {
          value: 'resources',
          label: 'Resources',
        },
      ],
    };
  }

  onChange = value => {
    const { dispatch } = this.props;

    this.setState({
      value,
    });

    dispatch(selectType(value));
  };

  render() {

    const options = {
      name: this.props.name,
      placeholder: this.props.placeholder,
      clearable: false,
      simpleValue: true,
      options: this.state.types,
      value: this.state.value,
      onChange: this.onChange,
    };

    return (
      <Select {...options} />
    );
  }
}

export default connect()(ContentTypeSelect);
