var routes = require('./routes.json');

export default  function () {
    var arg = Array.prototype.slice.call(arguments);
    var name = args.shift();

    if(routes[name] === undefined){
        console.log('Error');
    }else{
        return '/'+routes[name]
            .split('/')
            .map(function(str){
                if(str[0] == '{'){
                    return args.shift();
                }else{
                    return str;
                }
            })
            .json('/');
    }
}
