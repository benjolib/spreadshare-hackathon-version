// @flow
/**
 * Language api
 */
import { fetchDataApi } from "../../api";

/**
 * Retrieve languages
 */
export const getTables = searchTerm =>
  fetchDataApi(`table-search?q=${encodeURIComponent(searchTerm)}`);
