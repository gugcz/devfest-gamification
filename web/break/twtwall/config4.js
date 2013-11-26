var config = {
  // Twitter API (Proxy) URL
  baseUrl: 'http://quest.devfest.cz:7893',

  debug: false,
  title: 'DevFest Praha 2013 TwitterWall',

  search: '#DevFestCZ',
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
