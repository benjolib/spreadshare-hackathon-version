// @flow
import * as React from 'react';
import styled from 'styled-components';

const StyledDiv = styled.div`
  font-family: 'Montserrat', sans-serif;
  font-weight: 400;
  font-size: 16px;
  color: #6a7c94;

  & .htContextMenu table.htCore {
    font-family: 'Montserrat', sans-serif;
    border: none;
    color: #b1bbc7;
    font-weight: 400;
    font-size: 14px;
    -webkit-box-shadow: 3px 4px 10px 0px rgba(0, 0, 0, 0.45);
    -moz-box-shadow: 3px 4px 10px 0px rgba(0, 0, 0, 0.45);
    box-shadow: 3px 4px 10px 0px rgba(0, 0, 0, 0.45);
  }
  & .htContextMenu table.htCore tr td {
    height: 26px !important;
  }
  & .htContextMenu table.htCore tr td:first-child {
    padding-top: 10px;
  }
  & .htContextMenu table.htCore tr td.htDisabled {
    color: lightgray;
  }
  & .htContextMenu table.htCore tr td.htDisabled:hover {
    color: lightgray;
  }
  & .htContextMenu table.htCore .htSeparator {
    display: none;
  }
  & .table__main table.htCore thead tr th {
    border: none;
  }
  & .table__main table.htCore thead tr th div {
    background-color: #f2f2f8;
  }
  & .handsontable thead th .relative {
    padding-top: 14px;
    padding-bottom: 14px;
    color: #6a7c94;
    font-weight: 500;
  }
  & .handsontable tr:first-child td {
    border-top: none;
  }
  & .handsontable tr:first-child td.current.highlight {
    border-top: 2px solid #24ae69;
  }

  &.area.highlight {
    background: rgba(36, 174, 105, 0.3);
  }

  & .htBorders {
    .wtBorder.fill {
      background-color: #24ae69 !important;
    }
  }

  & .wtBorder.current,
  & .wtBorder.area,
  & .wtBorder.area.corner {
    background-color: rgb(36, 174, 105) !important;
  }

  & .handsontableInput {
    color: #6a7c94;
    box-shadow: 0 0 0 2px #24ae69 inset;
  }

  & td {
    border: none;
    padding: 10px;
  }
`;

type Props = {
  children?: React.Node,
};

const TableMain = (props: Props) =>
  <StyledDiv>
    {props.children}
  </StyledDiv>;

export default TableMain;
