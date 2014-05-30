var config = {
  // Twitter API (Proxy) URL
  baseUrl: 'http://caslav.studiopress.cz:7890',

  debug: false,
  title: 'mDevCamp 2014 TwitterWall',

  search: '#mDevCamp',
  //list: 'fullfrontalconf/delegates11', // optional, just comment it out if you don't want it

  timings: {
    showNextScheduleEarlyBy: '5m', // show the next schedule 10 minutes early
    defaultNoticeHoldTime: '10s',
    showTweetsEvery: '15s'
  }
};

// allows reuse in the node script
if (typeof exports !== 'undefined') {
  module.exports = config;
}
