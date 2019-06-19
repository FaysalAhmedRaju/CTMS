//<input id='radNo{0}' type='radio' name='choiceExtraBed{0}' checked='checked'/>&nbsp;&nbsp;No
//String.format(templateRow, i, i + 1);
String.format = function()
{
    if( arguments.length == 0 )
        return null;

    var str = arguments[0];
    for(var i=1;i<arguments.length;i++)
    {
        var re = new RegExp('\\{' + (i-1) + '\\}','gm');
        str = str.replace(re, arguments[i]);
    }
    return str;
}

String.trim = function()
{
    return arguments[0].replace(/^\s\s*/, '').replace(/\s\s*$/, '');
}

String.ltrim = function()
{
    return arguments[0].replace(/^\s\s*/, '');
}

String.rtrim = function()
{
    return arguments[0].replace(/\s\s*$/, '');
}
