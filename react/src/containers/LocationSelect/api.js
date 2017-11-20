// @flow
/**
 * Language api
 */
import { fetchDataApi } from "../../api";

/**
 * Retrieve languages
 */
export const getLocations = searchTerm =>
  fetchDataApi(`locations?q=${encodeURIComponent(searchTerm)}`);
