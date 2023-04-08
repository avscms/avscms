// harry plotter 0.9
// ~L~ nikomomo@gmail.com 2009-2013
// https://github.com/nikopol/Harry-Plotter

/*

//everything in the constructor is optional
//if data are provided, the graph is directly drawn

var h=harry({

	//datas can be provided in these formats :
	
	datas: [v1,v2,v3,...],        //simple dataset values
	datas: {l1:v1,l2:v2,l3:v3,..},//simple dataset labels/values
	datas: [[v1,v2],[w1,w2],...], //multiple dataset values
	datas: {                      //simple dataset with optionaly labels, color and title
		values: [v1,v2,...],      //  excepting values, all keys are
		labels: [l1,l2,...],      //  optionals in this format
		title: "my dataset #1",   //  values can also be an hash {label:value,...}
		color: "#fc0"
	},
	datas: [                      //multiple dataset with label,color and title
		{ values:[...],labels:[...],title:"...",color:"..." },
		{ values:[...],labels:[...],title:"...",color:"..." }
	],

	//context

	id: "str",                    //canvas's id, by default "harry"+count++
	container: "str/elem",	      //container where create canvas, default=body
	canvas: "str/elem",           //canvas element, default=create it into container
	width: int,                   //canvas's width, default=container.width or 300
	height: int,                  //canvas's height, default=container.height or 150
	
	//rendering

	background: "rgba(0,0,0,0.5)" //background color, default=transparent
	mode: "curve:stack",          //draw mode, can be:
	                              //  pie          cheesecake
	                              //  chart        histogram, side by side
	                              //  chart:stack  stacked histograms
	                              //  chart:vertical  vert. histograms
	                              //  chart:stack:vertical  vert. stacked histograms
	                              //  line         lines (default)
	                              //  line:stack   stacked lines
	                              //  curve        curved lines
	                              //  curve:stack  stacked curved lines
	barspace: int,                //space between bars for mode chart only, default=auto
	linewidth: int,               //line width, default=1
	linejoin: "round",            //line join, can be round|bevel|miter default=miter
	fill: "vertical",             //fill style (only first letter matter), can be:
	                              //  none         without fills
	                              //  solid        uniform fill (default)
	                              //  light        lighten color
	                              //  dark         darken color
	                              //  vertical     vertical gradient fill
	                              //  horizontal   horizontal gradient fill
	                              //  radial       radial gradient fill
	opacity: 0.8,                 //fill opacity, between 0 and 1
	margins:[top,right,bot,left], //margin size (for labels), default=auto
	autoscale: "top+bottom",      //auto round top and/or bottom y scale, default=none
	pointradius: int,             //radius point size in mode line/curve only, default=none
	anim: int,                    //initial animation duration in seconds, default=disabled

	title: {                      //title options
		text: "title",            //  clear enough
		font:'9px "Trebuchet MS"',//  font size & family, default=bold 12px "Sans Serif"
		color: "rgba(4,4,4,0.3)", //  font color, default=rgba(4,4,4,0.3)
		shadow: "x,y,blur,#col",  //  text shadow, default=none
		x: 5,                     //  title position left position
		y: 10,                    //  title position top position
		z: "background"           //  behind or on top of the graph, default=top
	},

	labels: {                     //axis labels options
		font: "9px Trebuchet MS", //  font size & family, important:use px size,
		                          //    default=normal 9px "Sans Serif"
		color: "#a0a0a0",         //  font color, default=a0a0a0
		shadow: "x,y,blur,#col",  //  label text shadow, default=none
		y: [0,50,100],            //  y axis, numbers are %, default=none
		ypos: "left+right",       //  y labels position, default=right
		x: int,                   //  x axis, display 1/int labels, 1=all..., default=none
		marks: int                //  graduation's marks size, default=0
	},

	legends: {                    //set to false to disable legends box, default=auto
		x: int,                   //  left corner position, default=5
		y: int,                   //  top corner position,  default=5
		background: "rgba(180,180,180,0.5)",//background color, default=rgba(255,255,255,0.5)
		border: "#fff",           //  legends border color, default=none
		shadowbox: "x,y,b,#col",  //  legends box shadow, default=none
		border2: "#fff",          //  color box border color, default=none
		color: "#000",            //  text color, default, #666
		shadow: "x,y,blur,#col",  //  legends text shadow, default=none
		font:'9px "Trebuchet MS"' //  font size & family, default=normal 10px "Sans Serif"
		layout: 'h'               //  legends layout h(orizontal) or v(ertical) default=v
	},

	grid: {                       //grid options
		color:"#a0a0a0",          //  grid color, default=#a0a0a0
		linewidth: int            //  grid linewidth default=1
		y: [0,50,100],            //  y axis, numbers are %, default=[0,25,50,75,100]
		x: "left|right|all|int"   //  x axis, int=display 1/n, default="left+right"
	},

	//interaction

	mouseover: {,                 //set to false to disable mouseover, default=enabled
		sort: true,               //  sort values, default=false
		bullet: "rgba(0,0,0,0.5)",//  bullet background color, default=rgba(99,99,99,0.8)
		border: "#fc0",           //  bullet border color, default=none,
		shadowbox: "x,y,b,#col",  //  bullet box shadow, default=none
		font: "9px Trebuchet MS", //  bullet text font, default=normal 9px "Sans Serif"
		color: "#666",            //  bullet text color, default=#fff
		shadow: "x,y,blur,#col",  //  bullet text shadow, default=none
		radius: int,              //  spot radius, default=5
		linewidth: int,           //  spot linewidth, default=linewidth below,0=fill
		circle: "#888888",        //  spot color, default=#888
		border2: "#fff",          //  spot color, default=none
		axis: "xy|x|y",           //  draw spot axis, default=none
		text: "%v",               //  text in the bullet (%v=value %l=label %n=index %t=title)
		text: callback(obj)       //  or text can trigger a callback
		                          //     if it returns a string, it'll be displayed
		header: {                 //  header in the bullet 
			text: "%v",               //  text in the bullet (same var than mouseover.text)
			font: "9px Trebuchet MS", //  bullet header font, default=mouveover.font
			color: "#666",            //  bullet text color, default=mouseover.color
			shadow: "x,y,blur,#col",  //  bullet text shadow, default=none
		}
	}
});

//or (same effect)
var h=plotter({...});


h.clear()             //delete all datasets
 .load(data)          //add a dataset (see contructor)
 .draw();             //draw all datasets
 .draw(mode);         //draw all datasets in a given mode (see constructor)

*/

var
harry=(function(o){
	"use strict";
	var

//CONSTS ======================================================================

	COLORS=["#88a4d7","#d685c9","#86d685","#ffc34f","#93c2ea","#f28989","#f9eb8a"],

//TOOLS LIB ===================================================================

	getRGB=function(color) {
		var r;
		if(color && color.constructor==Array && color.length==3) return color;
		if(r=/rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(color)) return [parseInt(r[1],10), parseInt(r[2],10), parseInt(r[3],10)];
		if(r=/rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)/.exec(color)) return [parseFloat(r[1])*2.55, parseFloat(r[2])*2.55, parseFloat(r[3])*2.55];
		if(r=/#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(color)) return [parseInt(r[1],16), parseInt(r[2],16), parseInt(r[3],16)];
		if(r=/#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/.exec(color)) return [parseInt(r[1]+r[1],16), parseInt(r[2]+r[2],16), parseInt(r[3]+r[3],16)];
		return [0,0,0];
	},

	calcColor=function(color,delta,alpha) {
		var rgb=getRGB(color),i;
		if(typeof delta!="array") delta=[delta,delta,delta];
		for(i=0;i<3;++i) rgb[i]=Math.max(Math.min(rgb[i]+delta[i],255),0);
		return (alpha!=undefined)?
			"rgba("+rgb.join(',')+","+alpha+")":
			"rgb("+rgb.join(',')+")";
	},

	fontPixSize=function(f) {
		var p=f.match(/\d+px/i);
		if(p) return parseInt(p,10);
		p=f.match(/[0-9\.]+em/i);
		if(p) return Math.floor(16.0*parseFloat(p));
		p=f.match(/\d+pt/i);
		if(p) return Math.floor(1.3333*parseInt(p,10));
		return 10;
	},

	scaleUp=function(n) {
		var s=Math.floor(n).toString(),
		    d=parseInt(s.substr(0,1),10),
		    m=d*parseFloat("1E"+(s.length-1));
		return m==n ? n : (d+1)*parseFloat("1E"+(s.length-1));
	},

	merge=function(a,b) {
		if(typeof(b)=='object')
			for(var k in b)
				a[k]=b[k];
		return a;
	},

	mouseXY=function(e) {
		e=e||window.event;
		if('offsetX' in e) return {x:e.offsetX,y:e.offsetY};
		var o=e.target,p={x:e.pageX,y:e.pageY};
		while(o.offsetParent){
			p.x-=o.offsetLeft;
			p.y-=o.offsetTop;
			o=o.offsetParent;
		}
		return p;
	},

	buildCanvas=function(o,w,h) {
		var c=document.createElement('canvas'),p;
		c.setAttribute('width',w+'px');
		c.setAttribute('height',h+'px');
		if(o) {
			p=typeof(o)=='string'?document.getElementById(o):o;
			if(!p) return;
		} else
			p=document.body;
		p.appendChild(c);
		return c;
	},

	calcMargins=function(flag,l,mo) {
		var m=fontPixSize(l.font);
		if(flag.pie) {
			m=l.x ? m*2 : (mo===false ? 0 : 15);
			return [m,m,m,m];
		}
		var
		ll=/l/i.test(l.ypos),
		lr=/r/i.test(l.ypos),
		f=Math.floor(m/2),
		k=l.marks;
		return flag.vertical ? [
		/*top*/    l.y && ll ? m+4 : (l.x?m:0),
		/*right*/  l.y ? m : 1,
		/*bottom*/ l.y && lr ? m+4 : (l.x?m:1),
		/*left*/   l.x ? 4+l.xwidth : (l.y?m:0)
		] : [
		/*top*/    l.y ? f : 0,
		/*right*/  l.y && lr ? 4+l.ywidth : (l.x?m:1),
		/*bottom*/ l.x ? 3+m+k : (l.y?m:1),
		/*left*/   l.y && ll ? 4+l.ywidth : (l.x?f:0)
		];
	},

	getMode=function(m) {
		return (m||'line').split(':')[0];
	},

	getFlag=function(m) {
		var o={},l=(m||'line').split(':');
		while(l.length) o[l.pop()]=true;
		return o;
	},

	percent=function(v,m) {
		return m ? (Math.round(1000*v/m)/10)+'%' : '0%';
	},

	strf=function(t,v) {
		var k,s="";
		if(t){
			s = typeof(t)=="function" ? t(v) : t;
			if(v) for(k in v) s=s.replace('%'+k,v[k]);
		}
		return s;
	},

	textBox=function(gc,t,v,m,b) {
		var n,w;
		if(!b) b={};
		if(!m) m=0;
		b.lines=strf(t,v).split(/\n|\\n/);
		b.lh=fontPixSize(gc.font)+m,
		b.h=b.lines.length*b.lh,
		b.w=0;
		for(n in b.lines) if((w=gc.measureText(b.lines[n]).width+m*2)>b.w) b.w=w;
		return b;
	},

//PRIVATE VARS ================================================================

	canvas=o.canvas
		? (o.canvas.constructor == HTMLCanvasElement ? o.canvas : document.getElementById(o.canvas))
		: buildCanvas(o.container,o.width||300,o.height||150),
	w=canvas.width,
	h=canvas.height,
	gc=canvas.getContext("2d"),
	imgdata,
	bg=o.background,
	flag=getFlag(o.mode),
	mode=getMode(o.mode),
	fill=(o.fill||"s")[0].toLowerCase().replace(/[^nsvhrdl]/g,"s"),
	opacity=parseFloat(o.opacity)||1,
	linewidth=o.linewidth==undefined?1:parseInt(o.linewidth,10),
	linejoin=o.linejoin||"miter",
	barspace=o.barspace==undefined?'a':parseInt(o.barspace,10),
	radiuspoint=parseInt(o.radiuspoint,10)||0,
	scaletop=o.autoscale && /top/i.test(o.autoscale),
	scalebot=o.autoscale && /bot/i.test(o.autoscale),
	labels=merge({
		color: "#a0a0a0",
		font: 'normal 9px "Sans Serif"',
		marks: 0,
		xwidth: 0,
		ywidth: 0,
		ypos: 'right'
	},o.labels),
	mo=o.mouseover===false
		? false
		: merge({
			radius: 5,
			linewidth: linewidth*2,
			circle: "#888",
			font: 'normal 10px "Sans Serif"',
			color: "#fff",
			bullet: "rgba(99,99,99,0.8)",
			axis: false,
			text: "%v"
		},o.mouseover),
	mousepos,
	overpts=[],
	overpie={n:false},
	automargins=o.margins ? false : true,
	margins=o.margins||[0,0,0,0],
	grid=merge({
		color: "#a0a0a0",
		linewidth: 1,
		x: 'lr',
		y: [0,25,50,75,100]
	},o.grid),
	title=o.title
		? merge({
			font: 'bold 12px "Sans Serif"',
			color: 'rgba(4,4,4,0.5)',
			z: 'top'
		},	o.title)
		: false,
	leg=o.legends===false
		? false
		: merge({
			color: "#666",
			font: '10px "Sans Serif"',
			layout: 'v'
		},o.legends),
	data=[], dmin, dmax, dlen=0, dsum, drng, dinc,
	rx, ry, rw, rh, rx2, ry2, lxl, acf=1,

//PRIVATE METHODS =============================================================

	draw,

	//setup precalc vars
	setup=function() {
		var i,j,l,d,s;
		//datasets vars
		dlen=data.length;
		dmin=dmax=false;
		drng=dsum=dinc=0;
		labels.xwidth=0;
		gc.font=labels.font;
		if(dlen) {
			for(i=0;i<dlen;i++) {
				d=data[i];
				dmin=dmin===false?d.min:Math.min(d.min,dmin);
				dmax=dmax===false?d.max:Math.max(d.max,dmax);
				if(d.maxlab) labels.xwidth=Math.max(labels.xwidth,gc.measureText(d.maxlab).width);
			}
			if(scaletop) dmax=scaleUp(dmax);
			if(flag.stack) {
				for(i=0,l=data[0].len;i<l;++i) {
					s=0;
					for(j=0;j<dlen;++j) s+=(data[j].val[i]||0);
					if(s>dsum) dsum=scaletop ? scaleUp(s) : s;
				}
				drng=scalebot ? dsum-dmin : dsum;
			} else {
				dsum=dmax;
				drng=scalebot ? dmax-dmin : dmax;
			}
			dinc=scalebot ? dmin : 0;
			labels.ywidth=gc.measureText(dsum||'0').width;
		}
		//misc
		labels.fontpx=fontPixSize(labels.font);
		if(labels.x=='auto'){
			labels.x=1;
			labels.xauto=true;
		}
		if(/none|false/.test(grid.y)) grid.y=[];
		//plot zone
		if(automargins) margins=calcMargins(flag,labels,mo);
		rx=margins[3];
		ry=margins[0];
		rw=Math.max(w-margins[1]-margins[3],0);
		rh=Math.max(h-margins[0]-margins[2],0);
		rx2=rx+rw;
		ry2=ry+rh;
	},

	//load a dataset
	load=function(d) { 
		var t,v,k,vals=d.values||d,labs=d.labels||[],l,
		ds={
			val:[], lab:[], len:0, sum:0, avg:0, max:0, min:0xffffffffffff,
			tit:d.title || "dataset#"+(data.length+1), maxlab: '',
			col:d.color || COLORS[data.length%COLORS.length]
		};
		for(k in vals) {
			v=parseFloat(vals[k]);
			if(isNaN(v)) v=null;
			ds.val.push(v);
			l=labs[k]||k;
			if(l.length>ds.maxlab.length) ds.maxlab=l;
			ds.lab.push(l);
			ds.sum+=v;
			if(v>ds.max) ds.max=v;
			if(v && v<ds.min) ds.min=v;
		}
		ds.len=ds.val.length;
		ds.avg=ds.len ? ds.sum/ds.len : 0;
		data.push(ds);
	},

	//load datasets
	loads=function(datas) {
		if(datas instanceof Array && typeof(datas[0])=='object')
			for(var i=0,l=datas.length;i<l;++i)
				load(datas[i]);
		else
			load(datas);
		setup();
	},

	//set and return a fillstyle
	setGradient=function(c) {
		var g;
		switch(fill) {
		case "s": //solid
			g=calcColor(c,0,opacity);
			break;
		case "l": //light
			g=calcColor(c,0x15,opacity);
			break;
		case "d": //dark
			g=calcColor(c,-0x15,opacity);
			break;
		case "v": //vertical
			g=gc.createLinearGradient(0,ry2,0,ry);
			g.addColorStop(0,calcColor(c,-0x30,opacity));
			g.addColorStop(1,calcColor(c,0x30,opacity));
			break;
		case "h": //horizontal
			g=gc.createLinearGradient(rx,0,rx2,0);
			g.addColorStop(0,calcColor(c,-0x30,opacity));
			g.addColorStop(1,calcColor(c,0x30,opacity));
			break;
		case "r": //radial
			var cx=rx+rw/2,cy=ry+rh/2;
			g=gc.createRadialGradient(cx,cy,0,cx,cy,rh/2);
			g.addColorStop(0,calcColor(c,-0x30,opacity));
			g.addColorStop(1,calcColor(c,0x30,opacity));
			break;
		}
		return g ? gc.fillStyle=g : false;
	},

	stroke=function(s){
		if(linewidth) {
			gc.lineWidth=linewidth;
			gc.lineJoin=linejoin;
			gc.strokeStyle=s;
			gc.stroke();
		}
	},
	
	fillstroke=function(s){
		gc.closePath();
		setGradient(s) && gc.fill();
		stroke(s);
	},

	//set shadow
	setShadow=function(s) {
		if(s && gc.hasOwnProperty('shadowBlur')) {
			var p=s.split(/[ ,;:-]/);
			gc.shadowOffsetX = parseInt(p[0]||1,10);
			gc.shadowOffsetY = parseInt(p[1]||1,10);
			gc.shadowBlur    = parseInt(p[2]||1,10);
			gc.shadowColor   = p[3]||'#000';
		}
	},

	//unset shadow
	unsetShadow=function() {
		if(gc.hasOwnProperty('clearShadow')) gc.clearShadow();
		else if(gc.hasOwnProperty('shadowBlur')) {
			gc.shadowOffsetX = 0;
			gc.shadowOffsetY = 0;
			gc.shadowBlur    = 0;
		}
	},

	//erase canvas
	cls=function() {
		gc.clearRect(-1,-1,w+1,h+1);
		if(bg) {
			gc.fillStyle=bg;
			gc.fillRect(-1,-1,w+1,h+1);
		}
	},

	drawTitle=function() {
		if(title) {
			setShadow(title.shadow);
			gc.font=title.font;
			gc.textAlign='left';
			gc.textBaseline='top';
			gc.fillStyle=title.color;
			gc.fillText(
				title.text,
				title.x==undefined?margins[3]+2:title.x,
				title.y==undefined?margins[0]+2:title.y
			);
			unsetShadow();
		}
	},
	
	//draw the background grid Y axis
	drawYGrid=function() {
		if(!flag.pie && grid.y) {
			var i,l,x,y;
			gc.lineWidth=grid.linewidth;
			gc.strokeStyle=grid.color;
			//console.log("[harry] grid x("+grid.x+") y("+grid.y.join(",")+")"); 
			for(i=0,l=grid.y.length;i<l;++i) {
				gc.beginPath();
				if(flag.vertical) {
					x=rx+Math.round(rw*grid.y[i]/100);
					gc.moveTo(x,ry);
					gc.lineTo(x,ry2);
				} else {
					y=ry2-Math.round(rh*grid.y[i]/100);
					gc.moveTo(rx,y);
					gc.lineTo(rx2,y);
				}
				gc.stroke();
			}
		}
	},

	//draw the background grid on X axis
	drawXGrid=function(x) {
		var i,y,
		l=x.length,
		gx=grid.x,
		ga=/a/i.test(gx),
		gl=/l/i.test(gx),
		gr=/r/i.test(gx),
		n=parseInt(gx,10);
		if(gx) {
			gc.lineWidth=grid.linewidth;
			gc.strokeStyle=grid.color;
			for(i=0;gx && i<l;++i) 
				if(ga || (n && i%n==0) || (i==0 && gl) || (i==l-1 && gr)) {
					gc.beginPath();
					if(flag.vertical) {
						gc.moveTo(rx,x[i]);
						gc.lineTo(rx2,x[i]);
					} else {
						gc.moveTo(x[i],ry);
						gc.lineTo(x[i],ry2);
					}
					gc.stroke();
				}
		}
	},

	//draw labels on Y axis
	drawYLabels=function() {
		if(dlen && labels.y) {
			//console.log("[harry] labels y("+labels.y.join(",")+") "+labels.font);
			if(!flag.pie) {
				var i,l,x,y,w,v,dec=drng<10?100:(drng<100?10:1);
				setShadow(labels.shadow);
				gc.font=labels.font;
				gc.fillStyle=labels.color;
				if(flag.vertical) {
					gc.textAlign='center';
					for(i=0,l=labels.y.length;i<l;++i) {
						x=rx+Math.round(rw*labels.y[i]/100);
						v=dinc+drng*labels.y[i]/100;
						v=Math.round(dec*v)/dec;
						if(/r/i.test(labels.ypos)) {
							y=ry2+1;
							gc.textBaseline='top';
							gc.fillText(v,x,y);
						}
						if(/l/i.test(labels.ypos)) {
							y=ry-2;
							gc.textBaseline='bottom';
							gc.fillText(v,x,y);
						}
					}
				} else {
					gc.textBaseline='middle';
					for(i=0,l=labels.y.length;i<l;++i) {
						y=ry2-Math.round(rh*labels.y[i]/100);
						v=dinc+drng*labels.y[i]/100;
						v=Math.round(dec*v)/dec;
						if(/r/i.test(labels.ypos)){
							x=rx2+1;
							gc.textAlign='left';
							gc.fillText(v,x,y);
						}
						if(/l/i.test(labels.ypos)) {
							x=rx-2;
							gc.textAlign='right';
							gc.fillText(v,x,y);
						}
					}
				}
				unsetShadow();
			}
		}
	},

	//draw labels on X axis
	drawXLabel=function(n,x,y,ta,tb,chk) {
		gc.save();
		x=Math.round(x);
		y=Math.round(y);
		if(labels.x && (n%labels.x)==0) {
			var
			ok=true,
			l=data[0].lab[n]||n,
			w=0;
			gc.font=labels.font;
			if(labels.xauto && chk) {
				w=gc.measureText(l).width;
				ok=!((chk=='h' && ta=='center' && x-w/2<lxl) || (chk=='v' && y<lxl));
			}
			if(ok) {
				setShadow(labels.shadow);
				gc.fillStyle=labels.color;
				gc.textAlign=ta;
				gc.textBaseline=tb;
				gc.fillText(l,x,y);
				unsetShadow();
				lxl=ta=='center'?x+w/2:y+labels.fontpx;
			}
		}
		if(labels.marks) {
			gc.lineWidth=1;
			gc.beginPath();
			gc.moveTo(x,ry2);
			gc.lineTo(x,ry2+labels.marks);
			gc.strokeStyle=labels.color;
			gc.stroke();
		}
		gc.restore();
	},

	drawLegends=function() {
		if(leg!==false && dlen>1) {
			gc.save();
			gc.font=leg.font;
			var i,w,g,px,py,d,lw=[],
			    hor=leg.layout=='h',
			    mw=0,
			    tw=0,
			    s=3,
			    lh=fontPixSize(leg.font)+s,
			    nl=dlen,
			    bs=lh-s,
			    tx=s*2+bs,
			    h=hor?s+lh:s+lh*nl,
			    x=leg.x!=undefined?leg.x:margins[3]+2,
			    y=leg.y!=undefined?leg.y:margins[0]+2+(title && !title.x?2+fontPixSize(title.font):0);
			for(i=0;i<nl;++i) {
				w=gc.measureText(data[i].tit).width;
				if(w>mw) mw=w;
				lw.push(w);
				tw+=w;
			}
			w=hor?(tx+s*2)*nl+tw:s*3+bs+mw;
			//draw background
			gc.lineWidth=1;
			if((g=leg.background)) {
				setShadow(leg.shadowbox);
				gc.fillStyle=g;
				gc.fillRect(x,y,w,h);
				unsetShadow();
			}
			if((g=leg.border)) {
				gc.strokeStyle=g;
				gc.strokeRect(x,y,w,h);
			}
			for(i=0,py=y+s,px=x+s;i<nl;++i) {
				d=data[i];
				//draw color box
				setShadow(leg.shadow);
				gc.fillStyle=d.col;
				gc.fillRect(px,py,bs,bs);
				unsetShadow();
				if((g=leg.border2)) {
					gc.strokeStyle=g;
					gc.strokeRect(px,py,bs,bs);
				}
				//draw text
				setShadow(leg.shadow);
				gc.textAlign='left';
				gc.textBaseline='top';
				gc.fillStyle=leg.color;
				gc.fillText(d.tit,px+s+bs,py);
				unsetShadow();
				if(hor) px+=s*4+bs+lw[i]; else py+=lh;
			}
			gc.restore();
		}
	},

	drawBullets=function(bs,center) { //[{x,y,r,v,n,nds}]
		gc.save();
		gc.font=mo.font;
		var i,n,m,l=bs.length,b,txt,bh=0,bw=0,s=3,
		    pt=fontPixSize(mo.font),
		    pr=Math.floor(pt/2),lh=pt+s,x,y,x1,y1,x2,y2,
		    xl=w,xr=0,yt=h,yb=0,mx=0,v,head;
		if(mo.sort) bs.sort(function(a,b){return parseFloat(b.v)-parseFloat(a.v)});
		//calc max for pct if needed
		for(n=0;n<l;n++) mx+=bs[n].v;
		//calc texts sizes
		for(n=0;n<l;n++){
			b=bs[n];
			v={
				v: b.v,
				l: data[b.nds].lab[b.n],
				n: b.n,
				t: data[b.nds].tit,
				p: b.pct||percent(b.v,mx)
			};
			b=textBox(gc,mo.text,v,s,b);
			if(b.w) {
				b.h2=Math.floor(b.h/2);
				if(b.w>bw) bw=b.w;
				bh+=b.h;
				b.r++;
				if(xl>b.x-b.r) xl=b.x-b.r;
				if(xr<b.x+b.r) xr=b.x+b.r;
				if(yt>b.y) yt=b.y;
				if(yb<b.y) yb=b.y;
			}
		}
		if(l>1) bw+=s*2+pt;
		if(bh) {
			if(mo.header) {
				if(mo.header.font) gc.font=mo.header.font;
				head=textBox(gc,mo.header.text,v,s);
				if(head.w>bw) bw=head.w;
				bh+=head.h;
			}
			bh+=s;
			//calc position
			if(center) {
				x=xl+(xr-xl)/2;
				x1=x-(bw/2);
				if(x1+bw>w) x1=w-1-bw;
				if(x1<1) x1=1;
			} else {
				x1=xr;
				if(x1+bw>=w) x1=xl-bw;
				if(x1<1) x1=1;
			}
			x1=Math.floor(x1);
			x2=x1+bw;
			y=yt+bh/2;
			y1=y+(bh/2);
			if(y1>ry2) y1=ry2-1;
			y1=Math.floor(y1);
			y2=y1-bh;
			//draw bullet
			gc.beginPath();
			gc.moveTo(x1,y1);
			gc.lineTo(x2,y1);
			gc.lineTo(x2,y2);
			gc.lineTo(x1,y2);
			gc.closePath();
			if(mo.bullet) {
				setShadow(mo.shadowbox);
				gc.strokStyle='';
				gc.fillStyle=mo.bullet;
				gc.fill();
				unsetShadow();
			}
			if(mo.border) {
				gc.lineWidth=1;
				gc.lineJoin='round';
				gc.strokeStyle=mo.border;
				gc.stroke();
			}
			//draw texts
			gc.textAlign='left';
			gc.textBaseline='top';
			y=y2+s;
			if(head) {
				x=x1+s;
				setShadow(mo.header.shadow);
				gc.fillStyle=mo.header.color||mo.color;
				for(i=0;i<head.lines.length;++i,y+=head.lh)
					gc.fillText(head.lines[i],x,y);
				unsetShadow();
				gc.font=mo.font;
			}
			for(n=0;n<l;n++) {
				b=bs[n];
				x=x1+s;
				if(l>1) {
					gc.beginPath();
					gc.arc(x+pr,y+pr,pr,0,2*Math.PI);
					gc.fillStyle=data[b.nds].col;
					gc.fill();
					x+=pt+s;
				}
				setShadow(mo.shadow);
				gc.fillStyle=mo.color;
				for(i=0;i<b.lines.length;++i,y+=lh)
					gc.fillText(b.lines[i],x,y);
				unsetShadow();
			}
		}
		gc.restore();
	},

	plot={

		line: function() {
			var nds=dlen,cy=drng?rh/drng:0,d,g,i,j,v,l,cu=mode=="curve",ly=ry2+labels.marks+2,
			drawPath=function(gc,x,y,v,n1,n2) {
				var n=n1,nx,ny,mx,my,px,py;
				while(n<=n2) {
					if(v[n]===null)
						n++;
					else if(cu) {
						nx=x[n];
						ny=y[n];
						n++;
						while(n<=n2 && v[n]===null) n++;
						if(n>n2)
							gc.lineTo(nx,ny);
						else {
							mx=(nx+x[n])/2;
							my=(ny+y[n])/2;
							px=(nx+mx)/2;
							py=(ny+my)/2;
							gc.quadraticCurveTo(nx,ny,px,py);
							px=(mx+x[n])/2;
							py=(my+y[n])/2;
							gc.quadraticCurveTo(mx,my,px,py);
						}
					} else {
						gc.lineTo(x[n],y[n]);
						n++;
					}
				}
			};
			overpts=[];
			while(d=data[--nds])
				if((l=d.len)>1) {
					//calc
					var x=[],y=[],n1,n2;
					for(i=0;i<l;++i) {
						v=0;
						if(flag.stack) for(j=0;j<=nds;j++) v+=data[j].val[i]-dinc;
						else v=d.val[i]-dinc;
						x.push(rx+Math.round(i*(rw/(l-1))));
						y.push(ry2-Math.round(cy*v*acf));
					}
					if(nds+1==dlen) drawXGrid(x);
					overpts.push({x:x,y:y,v:data[nds].val,nds:nds});
					i--;
					x.push(rx+Math.round(i*(rw/(l-1))));
					y.push(ry2-Math.round(cy*v));
					//dont draw leading/ending null values
					n1=0;
					while(d.val[n1]===null) n1++;
					n2=l-1;
					while(d.val[n2]===null) n2--;
					//fill
					if(n1<=n2 && setGradient(d.col)) {
						gc.beginPath();
						gc.moveTo(x[n1],ry2);
						gc.lineTo(x[n1],y[n1]);
						drawPath(gc,x,y,d.val,n1,n2);
						gc.lineTo(x[n2],ry2);
						gc.closePath();
						gc.fill();
					}
					//draw lines
					gc.beginPath();
					gc.moveTo(x[n1],y[n1]);
					drawPath(gc,x,y,d.val,n1,n2);
					stroke(d.col);
					//draw x labels
					if(nds==0)
						for(i=0;i<l;++i)
							drawXLabel(i,x[i],ly,'center','top','h');
					//draw points
					if(radiuspoint) {
						gc.fillStyle=d.col;
						for(i=0;i<l;++i)
							if(d.val[i]!=undefined){
								gc.beginPath();
								gc.arc(x[i],y[i],radiuspoint,0,2*Math.PI);
								gc.closePath();
								gc.fill();
							}
					}
				}
		},

		curve: function(){ plot.line() },

		chart: function() {
			//console.log("[harry] chart ("+dlen+" dataset)");
			overpts = [];
			if(dlen){
				var nd,nds,nbd=data[0].len,m=barspace=='a'?(dlen>1?4:0):barspace,
					fs=flag.stack,fv=flag.vertical,nbdsv=fs?1:dlen,tbw=fv?rh:rw,
					bw=(nbd && dlen)?(((tbw-(m*(nbd-1)))/nbd)/nbdsv)-1:0,
				    d,g,y,y1,y2,x,x1,x2,tcf=fv?rw:rh,ly=ry2+labels.marks+2,gx=[],
				    cf=fs?(dsum?tcf/dsum:0):(dmax?tcf/dmax:0);
				if(bw<0) bw=0;
				for(y=fv?ry:rx,g=(fv?rh:rw)/(nbd||1),nd=0;nd<=nbd;nd++) gx.push(Math.round(y+nd*g));
				drawXGrid(gx);
				for(nds=0;nds<dlen;nds++) overpts.push({x:[],y:[],v:[],nds:nds});
				if(fv)
					for(y=ry,nd=0;nd<nbd;nd++) {
						drawXLabel(nd,rx-labels.marks-2,y,'right','top','v');
						x=rx;
						for(nds=0;nds<dlen;nds++) {
							d=data[nds];
							x1=fs?x:rx;
							x=x1+Math.round(cf*d.val[nd]*acf);
							y1=Math.round(y);
							y2=Math.round(y+bw);
							if(d.val[nd]!==null) {
								gc.beginPath();
								gc.moveTo(x1,y1);
								gc.lineTo(x1,y2);
								gc.lineTo(x,y2);
								gc.lineTo(x,y1);
								fillstroke(d.col);
							}
							overpts[nds].x.push(x);
							overpts[nds].y.push(Math.floor(y+bw/2));
							overpts[nds].v.push(d.val[nd]);
							if(!fs) y+=bw+1;
						}
						y+=fs?bw+1+m:m;
					}
				else
					for(x=rx,nd=0;nd<nbd;nd++) {
						drawXLabel(nd,x+(((bw+1)*nbdsv)/2),ly,'center','top','h');
						y=ry2;
						for(nds=0;nds<dlen;nds++) {
							d=data[nds];
							y1=fs?y:ry2;
							y=y1-Math.round(cf*d.val[nd]*acf);
							x1=Math.round(x);
							x2=Math.round(x+bw);
							if(d.val[nd]!==null) {
								gc.beginPath();
								gc.moveTo(x1,y1);
								gc.lineTo(x1,y);
								gc.lineTo(x2,y);
								gc.lineTo(x2,y1);
								fillstroke(d.col);
							}
							overpts[nds].x.push(Math.floor(x+bw/2));
							overpts[nds].y.push(y);
							overpts[nds].v.push(d.val[nd]);
							if(!fs) x+=bw+1;
						}
						x+=fs?bw+1+m:m;
					}					
			}
		},

		pie: function() {
			//console.log("[harry] pie ("+dlen+" dataset)");
			overpts = [];
			if(dlen){
				//precalc angles
				var i,nb=0,va=[],vc=[],pi2=Math.PI*2,lab=[],pct=[];
				if(dlen>1) {
					var sum=0;
					for(i=0;i<dlen;i++) sum+=data[i].sum;
					if(sum)
						for(i=0,nb=dlen;i<dlen;i++) {
							va[i]=acf*data[i].sum/sum*pi2;
							vc[i]=data[i].col;
							lab.push(data[i].sum);
							pct.push(percent(data[i].sum,sum));
						}
				} else {
					var d=data[0];
					if(d.sum)
						for(nb=d.len,i=0;i<nb;i++) {
							va[i]=acf*d.val[i]/d.sum*pi2;
							vc[i]=COLORS[i%COLORS.length];
							lab.push(d.val[i]);
							pct.push(percent(d.val[i],d.sum));
						}
				}
				//draw
				var cx=rx+Math.round(rw/2),cy=ry+Math.round(rh/2),
				    r=Math.min(rh/2,rw/2)-1, rl=r+labels.fontpx,dx,dy,
				    g,a1=Math.PI*1.5,a2,a,nx,ny,n=overpie.n;
				overpie={r:r,x:cx,y:cy,n:n};
				for(i=0;i<nb;i++) {
					a2=a1+va[i];
					a=(a1+a2)/2;
					overpts.push({a:a1%(2*Math.PI),n:i});
					if(i===n) {
						dx=cx+Math.cos(a)*10;
						dy=cy+Math.sin(a)*10;
					} else {
						dx=cx;
						dy=cy;
					}
					gc.beginPath();
					gc.moveTo(dx,dy);
					gc.arc(dx,dy,r,a1,a2,false);
					fillstroke(vc[i]);
					if(i===n) {
						nx=dx+rl/2*Math.cos(a);
						ny=dy+rl/2*Math.sin(a);
					} else
						drawXLabel(lab[i],dx+rl*Math.cos(a),dy+rl*Math.sin(a),'center','middle');
					a1=a2;
				}
				if(n!==false) drawBullets([{
					x: nx,
					y: ny,
					r: 0,
					v: lab[n],
					pct: pct[n],
					n: n,
					nds: dlen>1?n:0
				}], true);
				overpts.sort(function(a,b){return a.a-b.a});
			}
		}
	},

	over={

		line: function(x,y) {
			var i,j,nb,n=false,p,m,c,lw=mo.linewidth||1,bs=[];
			if(overpts.length) {
				for(i=0;i<overpts[0].x.length;++i) {
					for(j=0;j<overpts.length;++j) {
						p=overpts[j];
						if(p.v[i]!=undefined) {
							c=flag.vertical ? Math.abs(y-p.y[i]) : Math.abs(x-p.x[i]);
							if(n===false || c<m) {
								m=c;
								n=i;
							}
							break;
						}
					}
				}
				if(n!==false) {
					for(i=0;i<overpts.length;++i) {
						p=overpts[i];
						if(p.v[n]!=undefined) {
							if(mo.border2) {
								gc.beginPath();
								gc.lineWidth=lw+2;
								gc.arc(p.x[n],p.y[n],mo.radius,0,2*Math.PI);
								if(mo.linewidth==0) {
									gc.fillStyle=mo.border2;
									gc.fill();
								} else {
									gc.strokeStyle=mo.border2;
									gc.stroke();
								}
							}
							gc.beginPath();
							gc.lineWidth=lw;
							gc.arc(p.x[n],p.y[n],mo.radius,0,2*Math.PI);
							if(mo.linewidth==0) {
								gc.fillStyle=mo.circle;
								gc.fill();
							} else {
								gc.strokeStyle=mo.circle;
								gc.stroke();
							}
							if(mo.axis){
								var xy,z,s=2;
								gc.lineWidth=1;
								//draw axis
								if(/x/i.test(mo.axis)){
									z=p.y[n]+mo.radius;
									while(z<ry2){
										gc.moveTo(p.x[n],z);
										z+=s;
										if(z>ry2) z=ry2;
										gc.lineTo(p.x[n],z);
										z+=s;
									}
									gc.stroke();
								}
								if(/y/i.test(mo.axis)){
									x=p.x[n]+mo.radius;
									while(x<rx2){
										gc.moveTo(x,p.y[n]);
										x+=s;
										if(x>rx2) x=rx2;
										gc.lineTo(x,p.y[n]);
										x+=s;
									}
									gc.stroke();
								}
							}
							bs.push({
								x: p.x[n],
								y: p.y[n],
								r: lw/2+1+mo.radius,
								v: p.v[n],
								n: n,
								nds: p.nds
							})
						}
					}
					drawBullets(bs);
				}
			}
		},

		chart: function(x,y){ over.line(x,y) },
		curve: function(x,y){ over.line(x,y) },

		pie: function(x,y) {
			var d=Math.sqrt(Math.pow(x-overpie.x,2)+Math.pow(y-overpie.y,2)),a,n,i=0;
			if(d<=overpie.r){
				a=Math.PI-Math.atan2(overpie.y-y,x-overpie.x);
				a=(a+3*Math.PI)%(2*Math.PI);
				while(i<overpts.length && a>overpts[i].a) i++;
				if(--i<0) i=overpts.length-1;
				overpie.n=overpts[i].n;
				draw(true);
			} else if(overpie.n!==false) {
				overpie.n=false;
				draw(true);
			}
		}

	},

	clear=function() {
		data=[];
		dlen=0;
		setup();
	},

	draw=function(nover) {
		//console.log("[harry] draw "+mode+" "+keys(flag).join(" "));
		lxl=-1;
		cls();
		drawYGrid();
		drawYLabels();
		if(title && title.z=='top') {
			plot[mode]();
			drawTitle();
		} else {
			drawTitle();
			plot[mode]();
		}
		drawLegends();
		if(!nover) {
			canvas.onmouseover=
			canvas.onmousemove=
			canvas.onmouseout=undefined;
			overpie.n=false;
			if(mo) {
				imgdata = gc.getImageData(0,0,w,h);
				if(mousepos) over[mode](mousepos.x,mousepos.y);
				canvas.onmouseover=function(e){
					mousepos=mouseXY(e);
				};
				canvas.onmousemove=function(e){
					if(mousepos) {
						if(!flag.pie) gc.putImageData(imgdata,0,0);
						mousepos=mouseXY(e);
						over[mode](mousepos.x,mousepos.y);
					};
				};
				canvas.onmouseout=function(){
					mousepos=undefined;
					gc.putImageData(imgdata,0,0);
				};
			} else
				mousepos=undefined;
		}
	},

	anim=function(s){
		var i=100/6,icf=1/(s*i),cb;
		cb=function(){
			draw();
			if(acf<1) {
				acf+=icf;
				if(acf>=1) acf=1;
				setTimeout(cb,i);
			}
		};
		acf=0;
		cb();
	};
	
//INIT ========================================================================

	//console.log("[harry] init("+w+","+h+")");
	gc.translate(0.5,0.5);
	if(o.datas) loads(o.datas);
	else setup();
	if(o.anim) anim(o.anim);
	else draw();

//PUBLIC METHODS ==============================================================

	return {
		canvas: canvas,
		data: data,
		clear: function() {
			clear();
			return this;
		},
		load: function(d) {
			loads(d);
			return this;
		},
		cls: function(){
			//console.log("harry.cls() is obsolete, cls is performed by draw()");
			return this;
		},
		draw: function(m) {
			if(m) {
				mode=getMode(m);
				flag=getFlag(m);
				setup();
			}
			draw();
			return this;
		}
	};
}),
plotter=harry;
