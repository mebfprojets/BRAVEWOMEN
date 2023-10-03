/*
 Highcharts JS v8.0.0 (2019-12-10)

 Sankey diagram module

 (c) 2010-2019 Torstein Honsi

 License: www.highcharts.com/license
*/
(function(b){"object"===typeof module&&module.exports?(b["default"]=b,module.exports=b):"function"===typeof define&&define.amd?define("highcharts/modules/sankey",["highcharts"],function(t){b(t);b.Highcharts=t;return b}):b("undefined"!==typeof Highcharts?Highcharts:void 0)})(function(b){function t(e,b,I,w){e.hasOwnProperty(b)||(e[b]=w.apply(null,I))}b=b?b._modules:{};t(b,"mixins/nodes.js",[b["parts/Globals.js"],b["parts/Utilities.js"]],function(e,b){var n=b.defined,w=b.extend,v=b.pick,m=e.Point;e.NodesMixin=
{createNode:function(b){function l(a,d){return e.find(a,function(a){return a.id===d})}var a=l(this.nodes,b),r=this.pointClass;if(!a){var q=this.options.nodes&&l(this.options.nodes,b);a=(new r).init(this,w({className:"highcharts-node",isNode:!0,id:b,y:1},q));a.linksTo=[];a.linksFrom=[];a.formatPrefix="node";a.name=a.name||a.options.id;a.mass=v(a.options.mass,a.options.marker&&a.options.marker.radius,this.options.marker&&this.options.marker.radius,4);a.getSum=function(){var c=0,d=0;a.linksTo.forEach(function(a){c+=
a.weight});a.linksFrom.forEach(function(a){d+=a.weight});return Math.max(c,d)};a.offset=function(c,d){for(var p=0,u=0;u<a[d].length;u++){if(a[d][u]===c)return p;p+=a[d][u].weight}};a.hasShape=function(){var c=0;a.linksTo.forEach(function(a){a.outgoing&&c++});return!a.linksTo.length||c!==a.linksTo.length};this.nodes.push(a)}return a},generatePoints:function(){var b=this.chart,l={};e.Series.prototype.generatePoints.call(this);this.nodes||(this.nodes=[]);this.colorCounter=0;this.nodes.forEach(function(a){a.linksFrom.length=
0;a.linksTo.length=0;a.level=a.options.level});this.points.forEach(function(a){n(a.from)&&(l[a.from]||(l[a.from]=this.createNode(a.from)),l[a.from].linksFrom.push(a),a.fromNode=l[a.from],b.styledMode?a.colorIndex=v(a.options.colorIndex,l[a.from].colorIndex):a.color=a.options.color||l[a.from].color);n(a.to)&&(l[a.to]||(l[a.to]=this.createNode(a.to)),l[a.to].linksTo.push(a),a.toNode=l[a.to]);a.name=a.name||a.id},this);this.nodeLookup=l},setData:function(){this.nodes&&(this.nodes.forEach(function(b){b.destroy()}),
this.nodes.length=0);e.Series.prototype.setData.apply(this,arguments)},destroy:function(){this.data=[].concat(this.points||[],this.nodes);return e.Series.prototype.destroy.apply(this,arguments)},setNodeState:function(b){var e=arguments,a=this.isNode?this.linksTo.concat(this.linksFrom):[this.fromNode,this.toNode];"select"!==b&&a.forEach(function(a){a.series&&(m.prototype.setState.apply(a,e),a.isNode||(a.fromNode.graphic&&m.prototype.setState.apply(a.fromNode,e),a.toNode.graphic&&m.prototype.setState.apply(a.toNode,
e)))});m.prototype.setState.apply(this,e)}}});t(b,"mixins/tree-series.js",[b["parts/Globals.js"],b["parts/Utilities.js"]],function(b,n){var e=n.extend,w=n.isArray,v=n.isNumber,m=n.isObject,x=n.pick,l=b.merge;return{getColor:function(a,r){var e=r.index,c=r.mapOptionsToLevel,d=r.parentColor,p=r.parentColorIndex,u=r.series,f=r.colors,k=r.siblings,g=u.points,h=u.chart.options.chart,y;if(a){g=g[a.i];a=c[a.level]||{};if(c=g&&a.colorByPoint){var l=g.index%(f?f.length:h.colorCount);var m=f&&f[l]}if(!u.chart.styledMode){f=
g&&g.options.color;h=a&&a.color;if(y=d)y=(y=a&&a.colorVariation)&&"brightness"===y.key?b.color(d).brighten(e/k*y.to).get():d;y=x(f,h,m,y,u.color)}var n=x(g&&g.options.colorIndex,a&&a.colorIndex,l,p,r.colorIndex)}return{color:y,colorIndex:n}},getLevelOptions:function(a){var b=null;if(m(a)){b={};var q=v(a.from)?a.from:1;var c=a.levels;var d={};var p=m(a.defaults)?a.defaults:{};w(c)&&(d=c.reduce(function(a,c){if(m(c)&&v(c.level)){var d=l({},c);var f="boolean"===typeof d.levelIsConstant?d.levelIsConstant:
p.levelIsConstant;delete d.levelIsConstant;delete d.level;c=c.level+(f?0:q-1);m(a[c])?e(a[c],d):a[c]=d}return a},{}));c=v(a.to)?a.to:1;for(a=0;a<=c;a++)b[a]=l({},p,m(d[a])?d[a]:{})}return b},setTreeValues:function c(b,q){var d=q.before,p=q.idRoot,u=q.mapIdToNode[p],f=q.points[b.i],k=f&&f.options||{},g=0,h=[];e(b,{levelDynamic:b.level-(("boolean"===typeof q.levelIsConstant?q.levelIsConstant:1)?0:u.level),name:x(f&&f.name,""),visible:p===b.id||("boolean"===typeof q.visible?q.visible:!1)});"function"===
typeof d&&(b=d(b,q));b.children.forEach(function(p,d){var f=e({},q);e(f,{index:d,siblings:b.children.length,visible:b.visible});p=c(p,f);h.push(p);p.visible&&(g+=p.val)});b.visible=0<g||b.visible;d=x(k.value,g);e(b,{children:h,childrenTotal:g,isLeaf:b.visible&&!g,val:d});return b},updateRootId:function(b){if(m(b)){var e=m(b.options)?b.options:{};e=x(b.rootNode,e.rootId,"");m(b.userOptions)&&(b.userOptions.rootId=e);b.rootNode=e}return e}}});t(b,"modules/sankey.src.js",[b["parts/Globals.js"],b["parts/Utilities.js"],
b["mixins/tree-series.js"]],function(b,n,t){var e=n.defined,v=n.isObject,m=n.pick,x=n.relativeLength,l=t.getLevelOptions,a=b.find,r=b.merge;n=b.seriesType;var q=b.Point;n("sankey","column",{borderWidth:0,colorByPoint:!0,curveFactor:.33,dataLabels:{enabled:!0,backgroundColor:"none",crop:!1,nodeFormat:void 0,nodeFormatter:function(){return this.point.name},format:void 0,formatter:function(){},inside:!0},inactiveOtherPoints:!0,linkOpacity:.5,minLinkWidth:0,nodeWidth:20,nodePadding:10,showInLegend:!1,
states:{hover:{linkOpacity:1},inactive:{linkOpacity:.1,opacity:.1,animation:{duration:50}}},tooltip:{followPointer:!0,headerFormat:'<span style="font-size: 10px">{series.name}</span><br/>',pointFormat:"{point.fromNode.name} \u2192 {point.toNode.name}: <b>{point.weight}</b><br/>",nodeFormat:"{point.name}: <b>{point.sum}</b><br/>"}},{isCartesian:!1,invertable:!0,forceDL:!0,orderNodes:!0,pointArrayMap:["from","to"],createNode:b.NodesMixin.createNode,setData:b.NodesMixin.setData,destroy:b.NodesMixin.destroy,
getNodePadding:function(){return this.options.nodePadding},createNodeColumn:function(){var a=this.chart,b=[],p=this.getNodePadding();b.sum=function(){return this.reduce(function(a,b){return a+b.getSum()},0)};b.offset=function(a,c){for(var d=0,f,h=0;h<b.length;h++){f=b[h].getSum()*c+p;if(b[h]===a)return{relativeTop:d+x(a.options.offset||0,f)};d+=f}};b.top=function(b){var c=this.reduce(function(a,c){0<a&&(a+=p);return a+=c.getSum()*b},0);return(a.plotSizeY-c)/2};return b},createNodeColumns:function(){var b=
[];this.nodes.forEach(function(c){var d=-1,p;if(!e(c.options.column))if(0===c.linksTo.length)c.column=0;else{for(p=0;p<c.linksTo.length;p++){var k=c.linksTo[0];if(k.fromNode.column>d){var g=k.fromNode;d=g.column}}c.column=d+1;g&&"hanging"===g.options.layout&&(c.hangsFrom=g,p=-1,a(g.linksFrom,function(a,b){(a=a.toNode===c)&&(p=b);return a}),c.column+=p)}b[c.column]||(b[c.column]=this.createNodeColumn());b[c.column].push(c)},this);for(var d=0;d<b.length;d++)"undefined"===typeof b[d]&&(b[d]=this.createNodeColumn());
return b},hasData:function(){return!!this.processedXData.length},pointAttribs:function(a,d){var c=this,u=c.mapOptionsToLevel[(a.isNode?a.level:a.fromNode.level)||0]||{},f=a.options,k=u.states&&u.states[d]||{};d=["colorByPoint","borderColor","borderWidth","linkOpacity"].reduce(function(a,b){a[b]=m(k[b],f[b],u[b],c.options[b]);return a},{});var g=m(k.color,f.color,d.colorByPoint?a.color:u.color);return a.isNode?{fill:g,stroke:d.borderColor,"stroke-width":d.borderWidth}:{fill:b.color(g).setOpacity(d.linkOpacity).get()}},
generatePoints:function(){function a(b,c){"undefined"===typeof b.level&&(b.level=c,b.linksFrom.forEach(function(b){a(b.toNode,c+1)}))}b.NodesMixin.generatePoints.apply(this,arguments);this.orderNodes&&(this.nodes.filter(function(a){return 0===a.linksTo.length}).forEach(function(b){a(b,0)}),b.stableSort(this.nodes,function(a,b){return a.level-b.level}))},translateNode:function(a,b){var c=this.translationFactor,d=this.chart,f=this.options,k=a.getSum(),g=Math.round(k*c),h=Math.round(f.borderWidth)%2/
2,e=b.offset(a,c);b=Math.floor(m(e.absoluteTop,b.top(c)+e.relativeTop))+h;h=Math.floor(this.colDistance*a.column+f.borderWidth/2)+h;h=d.inverted?d.plotSizeX-h:h;c=Math.round(this.nodeWidth);a.sum=k;a.shapeType="rect";a.nodeX=h;a.nodeY=b;a.shapeArgs=d.inverted?{x:h-c,y:d.plotSizeY-b-g,width:a.options.height||f.height||c,height:a.options.width||f.width||g}:{x:h,y:b,width:a.options.width||f.width||c,height:a.options.height||f.height||g};a.shapeArgs.display=a.hasShape()?"":"none";d=this.mapOptionsToLevel[a.level];
f=a.options;f=v(f)?f.dataLabels:{};d=v(d)?d.dataLabels:{};d=r({style:{}},d,f);a.dlOptions=d;a.plotY=1},translateLink:function(a){var b=a.fromNode,c=a.toNode,e=this.chart,f=this.translationFactor,k=Math.max(a.weight*f,this.options.minLinkWidth),g=this.options,h=b.offset(a,"linksFrom")*f,l=(e.inverted?-this.colDistance:this.colDistance)*g.curveFactor;h=b.nodeY+h;g=b.nodeX;f=this.nodeColumns[c.column].top(f)+c.offset(a,"linksTo")*f+this.nodeColumns[c.column].offset(c,f).relativeTop;var m=this.nodeWidth;
c=c.column*this.colDistance;var n=a.outgoing,q=c>g;e.inverted&&(h=e.plotSizeY-h,f=e.plotSizeY-f,c=e.plotSizeX-c,m=-m,k=-k,q=g>c);a.shapeType="path";a.linkBase=[h,h+k,f,f+k];if(q)a.shapeArgs={d:["M",g+m,h,"C",g+m+l,h,c-l,f,c,f,"L",c+(n?m:0),f+k/2,"L",c,f+k,"C",c-l,f+k,g+m+l,h+k,g+m,h+k,"z"]};else{l=c-20-k;n=c-20;q=c;var r=g+m,t=r+20,v=t+k,x=h,w=h+k,C=w+20;e=C+(e.plotHeight-h-k);var z=e+20,B=z+k,D=f,A=D+k,E=A+20,F=z+.7*k,G=q-.7*k,H=r+.7*k;a.shapeArgs={d:["M",r,x,"C",H,x,v,w-.7*k,v,C,"L",v,e,"C",v,F,
H,B,r,B,"L",q,B,"C",G,B,l,F,l,e,"L",l,E,"C",l,A-.7*k,G,D,q,D,"L",q,A,"C",n,A,n,A,n,E,"L",n,e,"C",n,z,n,z,q,z,"L",r,z,"C",t,z,t,z,t,e,"L",t,C,"C",t,w,t,w,r,w,"z"]}}a.dlBox={x:g+(c-g+m)/2,y:h+(f-h)/2,height:k,width:0};a.y=a.plotY=1;a.color||(a.color=b.color)},translate:function(){this.processedXData||this.processData();this.generatePoints();this.nodeColumns=this.createNodeColumns();this.nodeWidth=x(this.options.nodeWidth,this.chart.plotSizeX);var a=this,b=this.chart,e=this.options,m=this.nodeWidth,
f=this.nodeColumns,k=this.getNodePadding();this.translationFactor=f.reduce(function(a,c){return Math.min(a,(b.plotSizeY-e.borderWidth-(c.length-1)*k)/c.sum())},Infinity);this.colDistance=(b.plotSizeX-m-e.borderWidth)/Math.max(1,f.length-1);a.mapOptionsToLevel=l({from:1,levels:e.levels,to:f.length-1,defaults:{borderColor:e.borderColor,borderRadius:e.borderRadius,borderWidth:e.borderWidth,color:a.color,colorByPoint:e.colorByPoint,levelIsConstant:!0,linkColor:e.linkColor,linkLineWidth:e.linkLineWidth,
linkOpacity:e.linkOpacity,states:e.states}});f.forEach(function(b){b.forEach(function(c){a.translateNode(c,b)})},this);this.nodes.forEach(function(b){b.linksFrom.forEach(function(b){a.translateLink(b);b.allowShadow=!1})})},render:function(){var a=this.points;this.points=this.points.concat(this.nodes||[]);b.seriesTypes.column.prototype.render.call(this);this.points=a},animate:b.Series.prototype.animate},{applyOptions:function(a,b){q.prototype.applyOptions.call(this,a,b);e(this.options.level)&&(this.options.column=
this.column=this.options.level);return this},setState:b.NodesMixin.setNodeState,getClassName:function(){return(this.isNode?"highcharts-node ":"highcharts-link ")+q.prototype.getClassName.call(this)},isValid:function(){return this.isNode||"number"===typeof this.weight}});""});t(b,"masters/modules/sankey.src.js",[],function(){})});
//# sourceMappingURL=sankey.js.map