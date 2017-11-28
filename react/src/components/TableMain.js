// @flow
import * as React from "react";
import styled from "styled-components";

const StyledDiv = styled.div`
  font-family: "Montserrat", sans-serif;
  font-weight: 400;
  font-size: 14px;
  overflow: hidden;
  width: 100%;
  height: 80vh;
  background: #f3f2f8;
  padding-left: 20px;

  th {
    background: #f3f2f8;
    color: #6b7a91;
    height: 55px;
    line-height: 55px;
    font-weight: 700;
    font-size: 16px;
    text-align: left;
    border-color: transparent !important;
  }

  .colHeader {
    padding-left: 4px;
    padding-right: 4px;
  }

  td {
    padding-left: 8px;
    padding-right: 8px;
    color: #6e7d96 !important;
    font-weight: 500;
    border-color: transparent !important;
  }

  .handsontable tbody th.ht__highlight,
  .handsontable thead th.ht__highlight {
    background-color: #f3f2f8;
    color: #6b7a91;
  }

  .area.highlight {
    background: rgba(36, 174, 105, 0.3);
  }

  .wtBorder {
    background-color: #24ae69 !important;
  }
`;

type Props = {
  children?: React.Node
};

const TableMain = (props: Props) => <StyledDiv>{props.children}</StyledDiv>;

export default TableMain;
