// @flow
/* eslint-disable no-unused-expressions */
import {injectGlobal} from "styled-components";

// declare only some simple css which is hard to declare at component level
injectGlobal`
  html {
    font-size: 100%;
  }

  ::-webkit-input-placeholder { /* Chrome/Opera/Safari */
    color: #b1bbc7;
  }
  ::-moz-placeholder { /* Firefox 19+ */
    color: #b1bbc7;
  }
  :-ms-input-placeholder { /* IE 10+ */
    color: #b1bbc7;
  }
  :-moz-placeholder { /* Firefox 18- */
    color: #b1bbc7;
  }


  div.table-header {
    display: flex;
    background: #ffffff;
    padding: 20px 16px;
    font-size: 14px;
  }

  div.table-header button.table-button {
    color: white;
    padding: 0 15px;
  }

  div.table-header button.table-button img {
    margin-right: 5px;
    height: 16px;
    width: 16px;
  }

  div.table-header button.table-button.add-row {
    background: #9BAABF
  }

  div.table-header button.table-button.sort {
    background: #9BAABF
  }

  .htContextMenu table.htCore {
    background: #fff;
    border: none !important;
    border-radius: 10px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.3);
    overflow: hidden;
  }

  .htContextMenu table tbody tr td {
    padding: 8px 4px !important;
    color: #a8afbb;
  }
`;
