// @flow
/**
 * Language api
 */
import { fetchDataApi } from "../../api";

/**
 * Retrieve languages
 */
export const getTags = searchTerm =>
  fetchDataApi(`tags?q=${encodeURIComponent(searchTerm)}`);
