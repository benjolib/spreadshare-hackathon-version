export let URL = "";
if (process.env.NODE_ENV !== 'production') {
  URL = "http://dev.spreadshare.co:81";
}

export default URL;
