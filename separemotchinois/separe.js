function separeMot(text)
{
    var Segment = require('segment');
    var segment = new Segment();
    segment.useDefault();
    segment.loadSynonymDict('synonym.txt');
    segment.loadStopwordDict('stopword.txt');

    var result = segment.doSegment(text, 
        {
            stripPunctuation: true, 
            simple:true, convertSynonym: true
            //stripStopword: true
        });
    console.log(result);
    return result;
}

//var text = '关闭现在所有的IE窗口，并打开一个新窗口   ';
//separeMot(text);