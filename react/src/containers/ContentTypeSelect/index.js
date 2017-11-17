import React from 'react'
import Select from 'react-select'
import { connect } from 'react-redux';
import { selectType } from './actions';
import 'react-select/dist/react-select.css'

class ContentTypeSelect extends React.Component {
  constructor(props) {
    super(props)

    this.state = {
      value: null,
      types: [
        { value: 'contacts', label: 'Contacts' },
        { value: 'resources', label: 'Resources' }
      ]
    }
  }

  onChange = value => {
    const { dispatch } = this.props

    this.setState({
      value
    })

    dispatch(selectType(value))
  }

  render() {
    return (
      <Select
        name="contentType"
        clearable={false}
        options={this.state.types}
        simpleValue
        value={this.state.value}
        placeholder="Select type"
        onChange={this.onChange}
      />
    )
  }
}

export default connect()(ContentTypeSelect);
