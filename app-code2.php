<script type="text/javascript" src="<?=$_GET['mncDigitalUrl']?>/public/js/mncdig.min.js?t=<?=time()?>"></script>

<script type="text/javascript">

    var debug=true;

    $(document).ready(function() {
        mncdigAuth('<?=$_GET['username']?>', '<?=$_GET['appClientKey']?>');
        if(debug)console.log('mncdigAuth username:','<?=$_GET['username']?>' + ' ck:' + '<?=$_GET['appClientKey']?>');
        getRecommendationList();
        getProf();
        $("img").each(function(){
            $(this).attr("onerror","this.src='http://meplay.metube.co.id/images/default-thumb_small.jpg'");
        });
    })

    function getInfo(res) {
        var xmlhttp2 =  new XMLHttpRequest();
        var url = 'http://meplay.metube.co.id/getInfo.php?ids='+res;
        xmlhttp2.open('POST', url, true);
        xmlhttp2.onreadystatechange = function() {
            if(xmlhttp2.readyState == 4) {
                if(xmlhttp2.status != 200) {
                    if(debug)console.log('getInfo Connection problem, please try again.');
                    return;
                }
                var res0 = xmlhttp2.responseText;
                if(debug)console.log('getInfo responseText0:', res0);
                var res1 = JSON.parse(res0);
                if(debug)console.log('getInfo responseText1:', res1);
                if(res1.status == "success") {
                    var res2 = res1.data;
                    var lst='';
                    var lst1;
                    lst = '<table class="table table-striped">';

                    var ids = JSON.parse(res);
                    for(j=0;j<ids.length;j++) {

                        for(i=0;i<res2.length;i++) {
                            if(ids[j]==res2[i].id){
                                lst1 = res2[i].title;
                                if(lst1.length>37) {
                                    lst1 = lst1.substring(0,37) + '...';
                                }
                                lst += '<tr><td>' + (j+1).toString() + '.</td><td>' + lst1 + '</td></tr>';
                            }
                        }
                    
                    }                    
                    lst += '</table>';
                    $("#recom-list").html(lst);
                    if(debug)console.log('getInfo responseText2:', res2);
                }
            }
        }
        xmlhttp2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp2.send();
    }

    function getProf() {
        //if(typeof user_id === 'undefined'){
        var user_id = mncdigGetCookie('mncdigck');
            /*mncdigSetCookie('ZYJtVtGV','D4F154',365);*/
            if(user_id==''){
                user_id = mncdigGetCookie('ZxnsQxZ6IoI22OoX');/*user_id = getCookie('ZYJtVtGVrwLPqZfo');('ZYJtVtGVrwLPqZfo');*/
                if(user_id==''){
                    user_id = mncdigGetCookie('ZYJtVtGV');
                    if(user_id==''){
                        mncdigSetCookie('ZYJtVtGV',Math.floor(Math.random() * 16777216).toString(16)+Math.floor(Math.random() * 16777216).toString(16)+Math.floor(Math.random() * 16777216).toString(16)+Math.floor(Math.random() * 16777216).toString(16),365);
                    }
                }
                user_id = 'dev-' + user_id;
            }
        //}
        var xmlhttp2 =  new XMLHttpRequest();
        var url = 'http://meplay.metube.co.id/getProf.php?id=' + encodeURIComponent(user_id) + '&siteid=2';
        if(debug)console.log(url);
        xmlhttp2.open('POST', url, true);
        xmlhttp2.onreadystatechange = function() {
            if(xmlhttp2.readyState == 4) {
                if(xmlhttp2.status != 200) {
                    if(debug)console.log('getProf Connection problem, please try again.');
                    return;
                }
                var res1 = JSON.parse(xmlhttp2.responseText);
                if(debug)console.log('getProf responseText1:', res1);
                if(res1.status == "success") {
                    var res2 = res1.data;
                    var lst='';
                    var lst1;
                    var val1;
                    for(i=0;i<res2.length;i++) {
                        lst1 = res2[i].af_name;
                        val1 = res2[i].persen;
                        if(lst1.length>37) {
                            lst1 = lst1.substring(0,37) + '...';
                        }
                        lst += '<li><div>' + lst1 + '</div><div class="progress"><div class="progress-bar progress-bar-';
                        if(i==0) lst += 'success'; else lst += 'info';
                        lst += '" role="progressbar" aria-valuenow="' + val1 + '" aria-valuemin="0" aria-valuemax="100" style="width: ' + val1 + '%">' + val1 + '%</div></div></li>';
                        //lst += (i+1).toString() + '.' + lst1 + ' : ' + val1 + '%<br>';
                    }
                    $("#prof1-list").html(lst);
                    if(debug)console.log('getProf responseText2:', res2);
                }
            }
        }
        xmlhttp2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp2.send();
    }
    
    function getRecommendationList() {
      
        var res;
        var xmlhttp =  new XMLHttpRequest();
        xmlhttp.open('POST', 'http://meplay.metube.co.id/recommlist.php', true);
        xmlhttp.onreadystatechange = function() {
            if(xmlhttp.readyState == 4) {
                if(xmlhttp.status != 200) {
                    if(debug)console.log('getRecommendationList Connection problem, please try again.');
                    return;
                }
                res = decodeURIComponent(xmlhttp.responseText);                
                /*$("#recom-list").html(res);*/
                if(debug)console.log('getRecommendationList responseText:', res);
                if(res && res!="Recommendation list not found"){
                    getInfo(res);
                }
            }
        }
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var user_id = mncdigGetCookie('mncdigck');
        if(user_id == '') {
            user_id = mncdigGetCookie('ZxnsQxZ6IoI22OoX');
        }
        console.log('userid:', user_id);
        if(debug)console.log('getRecommendationList userid:', user_id);
        //xmlhttp.send('username='+encodeURIComponent(username));
        xmlhttp.send('userid='+encodeURIComponent(user_id));

        //res = '[ 154417,154477,155419 ]';
    }



    function getAdvProfile() {
        var res;
        var xmlhttp =  new XMLHttpRequest();
         xmlhttp.open('POST', 'http://meplay.metube.co.id/advprofile.php', true);
        xmlhttp.onreadystatechange = function() {
            if(xmlhttp.readyState == 4) {
                if(xmlhttp.status != 200) {
                    if(debug)console.log('getAdvProfile Connection problem, please try again.');
                    return;
                }
                res = decodeURIComponent(xmlhttp.responseText);                
                /*$("#recom-list").html(res);*/
                if(debug)console.log('getAdvProfile responseText:', res);
                if(res && res!="Profiling list not found"){
                    getInfo(res);
                }
            }
        }
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var user_id = mncdigGetCookie('mncdigck');
        if(user_id == '') {
            user_id = mncdigGetCookie('ZxnsQxZ6IoI22OoX');
        }
        console.log('userid:', user_id);
        if(debug)console.log('getAdvProfile userid:', user_id);
        //xmlhttp.send('username='+encodeURIComponent(username));
        xmlhttp.send('userid='+encodeURIComponent(user_id));

        //res = '[ 154417,154477,155419 ]';
    }

</script>