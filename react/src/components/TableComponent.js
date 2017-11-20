// @flow
import React from "react";
import HotTable from "react-handsontable";
import styled from "styled-components";

export default ({ data }) =>
  <div className="table">
    <header className="table__header">
      <button className="table__header__button">
        <img src="/assets/icons/sort.svg" alt="" />
      </button>
      <button className="table__header__button">
        <img src="/assets/icons/filter.svg" alt="" />
      </button>
      <button className="table__header__button">
        <img src="/assets/icons/add.svg" alt="" />
      </button>
      <div className="table__header__search">
        <button>
          <img src="/assets/icons/search.svg" alt="" />
        </button>
        <input type="text" placeholder="Search Table" />
      </div>
      <button className="table__header__button">
        <img src="/assets/icons/eye.svg" alt="" />
      </button>
    </header>
    <main className="table__main">
      <StyledTable
        className="table__main__hotTable"
        data={data}
        contextMenu
        colHeaders={["Votes", "Name", "Functionality", "URL", "Price"]}
        stretchH="all"
        columns={[{}, {}, {}, {}, {}]}
      />
    </main>
  </div>;

const StyledTable = styled(HotTable)`
  font-family: 'Montserrat', sans-serif;
  font-weight: 400;
  font-size: 16px;
  color: #6A7C94;

  &.area.highlight {
    background: rgba(36, 174, 105, 0.3);
  }

  .htBorders {
    .wtBorder.fill {
      background-color: #24AE69 !important;
    }
  }

  .wtBorder.current, .wtBorder.area, .wtBorder.area.corner {
    background-color: rgb(36, 174, 105) !important;
  }

  .handsontableInput {
    color: #6A7C94;
    box-shadow: 0 0 0 2px #24AE69 inset;
  }

  td {
    border: none;
    padding: 10px;
  }
`;
