var diagram = "";
window.onload = function () {
    var width = screen.availWidth - 500;
    var height = screen.availHeight - 200;
    if (width < 400) width = width;
    if (width > 1000) width = 500;
    var vistaa = new Application({id: 'umldiagram', width: width, height: height});
    $("#umldiagram").click(function () {
        var xml = vistaa.getXMLString();
        diagram = xml;
        firebase.database().ref('dia_sec').set({sec: diagram});
    });
    firebase.database().ref('dia_sec')
        .on('value', function (snapshot) {
            if (diagram != snapshot.val().sec) {
                var d = snapshot.val().sec;
                console.log(d);
                vistaa._delDiagram();
                vistaa.setXMLString(d);
            }
        });
}
