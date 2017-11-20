// @flow
/**
 * Language api
 */
import fetchDataApi from '../../api';

/**
 * Retrieve languages
 */
export const getLocations = (searchTerm) => {
  return fetchDataApi(`locations?q=${encodeURIComponent(searchTerm)}`);
};
