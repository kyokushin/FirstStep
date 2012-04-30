/**
@fileOverview brook/widget.js
@author daichi.hiroki<hirokidaichi@gmail.com>
*/


/**
@name brook.widget
@namespace details here
*/
Namespace('brook.widget')
.use('brook promise')
.use('brook.channel *')
.use('brook.util *')
.use('brook.dom.compat *')
.define(function(ns){
    var TARGET_CLASS_NAME = 'widget';

    var classList = ns.classList;
    var dataset   = ns.dataset;
    var widgetChannel = ns.channel('widget');
    var errorChannel  = ns.channel('error');

    var removeClassName = function(className,element){
        classList(element).remove(className);
    };
    var elementsByClassName = ns.promise(function(n,v){
        v = v || TARGET_CLASS_NAME;
        n([v,Array.prototype.slice.call(ns.getElementsByClassName(v))]);
    });
    var mapByNamespace = ns.promise(function(n,val){
        var targetClassName = val[0];
        var widgetElements  = val[1];
        var map = {};
        for( var i = 0,l = widgetElements.length;i<l;i++){
            var widget = widgetElements[i];
            removeClassName((targetClassName||TARGET_CLASS_NAME),widget);
            var data            = dataset(widget);
            var widgetNamespace = data.widgetNamespace;
            if( !widgetNamespace ) continue;
            if( !map[widgetNamespace] ) map[widgetNamespace] = [];
            map[widgetNamespace].push( [widget, data] );
        }
        n(map);
    });
    var mapToPairs = ns.promise(function(n,map){
        var pairs = [];
        for( var namespace in map )
            if( map.hasOwnProperty( namespace ) )
                pairs.push([namespace, map[namespace]]);
        n(pairs);
    });
    var applyNamespace = ns.promise(function(n, pair) {
        Namespace.use([pair[0] , '*'].join(' ')).apply(function(ns){
            n([ns, pair[1]]);
        });
    });
    var registerElements = ns.promise(function(n, v) {
        var _ns       = v[0];
        var widgets   = v[1];
        var i,l;
        try {
            if (_ns.registerElement) {
                for( i=0,l=widgets.length;i<l;i++){
                    _ns.registerElement.apply(null, widgets[i]);
                }
            } else if (_ns.registerElements) {
                var elements = [];
                for( i=0,l=widgets.length;i<l;i++){
                    elements.push(widgets[i][0]);
                }
                _ns.registerElements(elements);
            } else {
                throw('registerElement or registerElements not defined in ' + _ns.CURRENT_NAMESPACE);
            }
        }
        catch (e) {
            errorChannel.sendMessage(e);
        }
    });

    var updater = ns.promise()
        .bind( 
            ns.lock('class-seek'),
            elementsByClassName,
            mapByNamespace,
            mapToPairs,
            ns.unlock('class-seek'),
            ns.scatter(),
            applyNamespace,
            registerElements
        );

    widgetChannel.observe(updater);

    ns.provide({
        bindAllWidget : widgetChannel.send()
    });
});

