// @flow
import React from "react";
import styled from "styled-components";

const StyledDiv = styled.div`
  text-align: center;
  height: 100%;
  padding: 0 0 8px 0;
  input {
    width: 100%;
    background: white;
    border-radius: 6px;
    border: none;
    height: 40px;
    text-indent: 12px;
    color: #808a9a;
  }
`;

type Props = {
  colIndex: number,
  setupDataGetter: (dataGetter: Function) => void,
  value: string
};

type State = {
  value: string
};

class AddInputCell extends React.Component<Props> {
  props: Props;
  state: State;

  state = {
    value: ""
  };

  componentDidMount() {
    console.log(this.props.value);
    this.props.setupDataGetter(this.props.colIndex, () => {
      const val = this.state.value;
      this.setState({ value: "" });
      return val;
    });
  }

  onChange = e =>
    this.setState({
      value: e.target.value
    });

  render() {
    return (
      <StyledDiv>
        <input type="text" onChange={this.onChange} value={this.state.value} />
      </StyledDiv>
    );
  }
}

export default AddInputCell;
