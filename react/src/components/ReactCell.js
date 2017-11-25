import React from "react";

class ReactCell extends React.Component {
  constructor(props) {
    super(props);
    this.state = { counter: 0 };
  }

  componentDidMount() {
    const { row } = this.props;
    this.interval = setInterval(
      () =>
        this.setState({
          counter: this.state.counter + 1
        }),
      500
    );
    console.log("mounting", row);
  }

  componentWillUnmount() {
    const { row } = this.props;
    clearInterval(this.interval);
    console.log("unmounting", row);
  }

  render() {
    return (
      <span onClick={() => console.log("jeff")}>
        ROW: {this.props.row}, counter: {this.state.counter}
      </span>
    );
  }
}

export default ReactCell;
