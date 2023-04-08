// harry plotter timeline serie generator - 0.1
// ~L~ nikomomo@gmail.com 2012-2013
// https://github.com/nikopol/Harry-Plotter

/*
require: harry.js (sic!)

generate date/time data series for harry
from incomplete data.

method:

	harry.timeline.year(data,fnparse,fnfmt)
	harry.timeline.month(data,fnparse,fnfmt)
	harry.timeline.week(data,fnparse,fnfmt)
	harry.timeline.day(data,fnparse,fnfmt)
	harry.timeline.hour(data,fnparse,fnfmt)
	harry.timeline.minute(data,fnparse,fnfmt)
	harry.timeline.second(data,fnparse,fnfmt)

params:

	   data: data in form { date1: value, dateX: value, .... }
	fnparse: a function for parsing data's date
	         param provided is a string with the date to parse
	         default: function(d){ return new Date(d) }
	  fnfmt: a function to format displayed dates
	         param provided is a Date object
	         default depends on method
	         eg: function(d){ return new Date(d) }

usage:

var dt = {
	'2012-05-12': 42,
	'2012-06-28': 12,
	'2013-09-05': 65
};

plotter({ datas: harry.timeline.day(dt) });

*/

harry.timeline = (function(){
	"use strict";
	var
	build = function(series,dur,fnparse,fnfmt){
		var min=null,max=null,r=[],ds=[],labs=[],nlabs={},ns,nl,d,n,k;
		if(!(series instanceof Array)) series=[series];
		dur*=1000;
		//norm+min&max
		for(ns in series){
			var s={};
			for(k in series[ns]){
				d=fnparse(k);
				n=Math.floor(d.getTime()/dur)*dur;
				if(min===null || n<min) min=n;
				if(max===null || n>max) max=n;
				var v=parseFloat(series[ns][k]);
				if(s[n]) s[n]+=v; else s[n]=v;
			}
			ds.push(s);
		}
		//init
		for(nl in ds) {
			var o={
				values: [],
				labels: []
			};
			if(nl==0)
				for(n=min,nl=0;n<=max;n+=dur,nl++) {
					labs.push(fnfmt(new Date(n)));
					nlabs[n]=nl;
				}
			for(n=min;n<=max;n+=dur) o.values.push(null);
			o.labels=labs;
			r.push(o);
		}
		//fill
		for(ns in ds)
			for(n in ds[ns]){
				nl=nlabs[n];
				r[ns].values[nl]=ds[ns][n];
			}
		return r;
	},
	parse = function(d){ 
		var o = new Date(d);
		if(!isNaN(o)) return o;
		if(/^(\d{4})\D(\d{2})\D(\d{2})(?:\D(\d{2}))?(?:\D(\d{2}))?(?:\D(\d{2}))?/.test(d) )
			return new Date(RegExp.$1,RegExp.$2-1,RegExp.$3,RegExp.$4||0,RegExp.$5||0,RegExp.$6||0);
		console.log("unable to parse date ",d," please setup a parser");
		return null;
	},
	fmtiso55 = function(d){ return d.toISOString().substr(5,5) },
	fmttime5 = function(d){ return d.toTimeString().substr(0,5) },
	fmttime8 = function(d){ return d.toTimeString().substr(0,8) };
	return {
		year:  function(s,fnparse,fnfmt){ return build(s,365*60*60,fnparse||parse,fnfmt||fmtiso55) },
		month: function(s,fnparse,fnfmt){ return build(s,31*60*60,fnparse||parse,fnfmt||fmtiso55) },
		week:  function(s,fnparse,fnfmt){ return build(s,7*24*60*60,fnparse||parse,fnfmt||fmtiso55) },
		day:   function(s,fnparse,fnfmt){ return build(s,24*60*60,fnparse||parse,fnfmt||fmtiso55) },
		hour:  function(s,fnparse,fnfmt){ return build(s,60*60,fnparse||parse,fnfmt||fmttime5) },
		minute:function(s,fnparse,fnfmt){ return build(s,60,fnparse||parse,fnfmt||fmttime8) },
		second:function(s,fnparse,fnfmt){ return build(s,1,fnparse||parse,fnfmt||fmttime8) }
	};
})();