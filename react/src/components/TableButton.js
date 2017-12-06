// @flow
import React from "react";
import styled from "styled-components";

const StyledButton = styled.button`
  border: 0;
  padding: 0;
  border-radius: 3px;
  margin: 0 4px;
  cursor: pointer;
`;

type Props = {
  icon: string
};

const TableButton = (props: Props) => (
  <StyledButton {...props}>
    <img src={`/assets/icons/${props.icon}.svg`} alt="" />
    { props.children ? props.children : null }
  </StyledButton>
);

export default TableButton;
