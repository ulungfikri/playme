<script type="text/javascript" src="<?=$_GET['mncDigitalUrl']?>/public/js/mncdig.min.js?t=<?=time()?>"></script>

<script type="text/javascript">

    var debug=true;

    $(document).ready(function() {
        mncdigAuth('<?=$_GET['username']?>', '<?=$_GET['appClientKey']?>');
        if(debug)console.log('mncdigAuth username:','<?=$_GET['username']?>' + ' ck:' + '<?=$_GET['appClientKey']?>');
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

</script>
