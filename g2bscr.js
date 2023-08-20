$(document).ready(function() 
{
    $(document).on('change', "#type", function()
    {
        let type = document.querySelector("#type").value;

        for(let i = 1; i <= 4; i++)
        {
            for(let j = 0; j < document.querySelectorAll(".List"+i).length; j++)
            {
                document.querySelectorAll(".List"+i)[j].style.display = "none";
            }
        }

        for(let i = 0; i < document.querySelectorAll(".List"+type).length; i++)
        {
            document.querySelectorAll(".List"+type)[i].style.display = "revert";
        }
        document.querySelector("#src").attributes["rowspan"].value = document.querySelectorAll(".List"+type).length + 2;
        document.querySelector("#excel").attributes["rowspan"].value = document.querySelectorAll(".List"+type).length + 2;
    })

    $(document).on("change", "#chgdyn", function()
    {
        if(document.querySelector("#chgdyn").checked == true) document.querySelector("#chgd").disabled = false;
        else document.querySelector("#chgd").disabled = true;
    })

    $(document).on("change", "#selType", function()
    {
        let tip = document.querySelector("#shopEsse");
        if(document.querySelector("#selType").value == "1") 
            tip.innerHTML = "쇼핑계약번호";
        else tip.innerHTML = "쇼핑계약번호<font style='font-size:12px;color:red;'>(*)</font>";
    })

    $(document).on('click', "#src", function()
    {
        let type = document.querySelector("#type").value;
        createURL(type);
    });

    $(document).on('click', "#id_page", function()
    {
        let type = document.querySelector("#type").value;
        let page = $("#pageselect").val();

        createURL(type, page);
    });

    let input = document.querySelectorAll(".txt");
    for(let i = 0; i < input.length; i++)
    {
        input[i].onkeypress = function(e)
        {
            if(e.which == '13') 
            {
                e.preventDefault();
                let type = document.querySelector("#type").value;
        
                createURL(type);
            }
        }
    }

    $(document).on('click', '#excel', function()
    {
        document.querySelector("#sendform").attributes['action'].value = "dataExcel.php";
        alert("잠시 기다려 주세요~ 이미지 변환중 입니다!");
        $("#sendform").submit();
    })
});

function createURL(type, page = "1")
{
    document.querySelector("#src").innerHTML = "Ing";

    let url = "http://apis.data.go.kr/1230000/ShoppingMallPrdctInfoService05/";
    let key = "nupsGtUQ7LrFavR3s9HVdPyHSiMBXgtHWoYlrriBiTypeNauxH34YRpQy1sMTzefqh53Tvg0KpMf2V4hZUo3xA%3D%3D";
    let year = document.querySelector("#year").value;
    let name = document.querySelector("#name").value;

    if(type == "1") url += "getMASCntrctPrdctInfoList";
    else if(type == "2") url += "getThptyUcntrctPrdctInfoList";
    else if(type == "3") url += "getShoppingMallPrdctInfoList";
    else if(type == "4") url += "getVntrPrdctOrderDealDtlsInfoList";

    url += `?numOfRows=100&pageNo=${page}`;
    url += `&ServiceKey=${key}`;
    url += `&type=json`;
    if(name != "") url += `&prdctClsfcNoNm=${encodeURIComponent(name)}`;

    if(type == "1" || type == "2")
    {    
        let num = document.querySelector("#num").value;
        let cnt = document.querySelector("#cnt").value;
        let prod = "N";
        if(document.querySelector("#prod").checked == true) prod = "Y";
        
        url += `&rgstDtBgnDt=${year}01010000`;
        url += `&rgstDtEndDt=${year}12312359`;
        
        if(document.querySelector("#chgdyn").checked == true)
        {
            let chgd = document.querySelector("#chgd").value;

            url += `&chgDtBgnDt=${chgd}01010000`;
            url += `&chgDtEndDt=${chgd}12312359`;
        }
        if(num != "") url += `&prdctIdntNo=${num}`;
        if(cnt != "") url += `&cntrctCorpNm=${encodeURIComponent(cnt)}`;
        if(prod != "") url += `&prodctCertYn=${prod}`;
    }
    else
    {
        let selType = document.querySelector("#selType").value;
        let dtil = document.querySelector("#dtil").value;
        let prdc = document.querySelector("#prdc").value;

        url += `&inqryBgnDate=${year}0101`;
        url += `&inqryEndDate=${year}1231`;
        url += `&inqryDiv=${selType}`;
        if(dtil != "") url += `&dtilPrdctClsfcNoNm=${encodeURIComponent(dtil)}`;
        if(prdc != "") url += `&prdctIdntNoNm=${encodeURIComponent(prdc)}`;

        if(type == "3")
        {
            let excl = "N";
            let mas = "N";
            let prod = "N";
            let regt = "N";
            if(document.querySelector("#excl").checked == true) excl = "Y";
            if(document.querySelector("#mas").checked == true) mas = "Y";
            if(document.querySelector("#prod2").checked == true) prod = "Y";
            if(document.querySelector("#regt").checked == true) regt = "Y";
            let shop = document.querySelector("#shop").value;

            if(selType == "2" && shop == "")
            {
                alert("(*)는 필수 작성 항목입니다.");
                document.querySelector("#src").innerHTML = "검색";
                return false;
            }
            
            if(excl != "") url += `&exclcProdctYn=${excl}`;
            if(mas != "") url += `&masYn=${mas}`;
            if(prod != "") url += `&prodctCertYn=${prod}`;
            if(shop != "") url += `&shopngCntrctNo=${shop}`;
            if(regt != "") url += `&regtCncelYn=${regt}`;
        }
        else
        {
            let dmin = document.querySelector("#dmin").value;
            let dminn = document.querySelector("#dminNm").value;

            if(dmin != "") url += `&dminsttNm=${encodeURIComponent(dmin)}`;
            if(dminn != "") url += `&dminsttRgnNm=${encodeURIComponent(dminn)}`;
        }
    }

    console.log(url);
    send(url, name, year, page);
}


function send(url, name, year, page)
{
    $.ajax(
    {
        url: "./dataSend.php",
        dataType:"json",
        type:"POST", 
        data: { url:url },
        async:true,
        cache:false,
        success: function(data)
        {
            console.log(data);
            document.querySelector("#src").innerHTML = "검색";

            let result = JSON.parse(data);
            if( result['response']['header']['resultCode'] == "00" )
            {
                $("#tbody").empty();
                $(".cs_page").empty();

                $("#tbody").append("<tr id='title' style='position:sticky;top:0px; background-color: #738bd5;'>");
                $("#title").append("<th width='40%'>이미지</th>");
                $("#title").append("<th>계약업체명</th>");
                $("#title").append("<th>물품규격명</th>");
                $("#title").append("<th>계약가격금액</th>");
                $("#title").append("<th>물품원산지명</th>");
                $("#title").append("<th>물품제조사명</th>");
                
                let totalcnt = result['response']['body']['totalCount'];
                let i =0;

                if(totalcnt > 0)
                {
                    if(result['response']['body']['items'].length != 0)
                    {
                        for(i = 0; i < result['response']['body']['items'].length; i++)
                        {
                            $("#tbody").append("<tr id='tableBody" + i + "'>");
                            $("#tableBody" + i).append("<td><img src='" + result['response']['body']['items'][i]['prdctImgUrl'] + "'></td>");
                            $("#tableBody" + i).append("<td>" + result['response']['body']['items'][i]['cntrctCorpNm'] + "</td>");
                            $("#tableBody" + i).append("<td>" + result['response']['body']['items'][i]['prdctSpecNm'] + "</td>");
                            $("#tableBody" + i).append("<td>" + result['response']['body']['items'][i]['cntrctPrceAmt'] + "</td>");
                            $("#tableBody" + i).append("<td>" + result['response']['body']['items'][i]['prdctOrgplceNm'] + "</td>");
                            $("#tableBody" + i).append("<td>" + result['response']['body']['items'][i]['prdctMakrNm'] + "</td>");
    
                            $("#sendform").append("<input type='hidden' name='prdctImgUrl" + i + "' value='" + result['response']['body']['items'][i]['prdctImgUrl'] +"'>");
                            $("#sendform").append(`<input type='hidden' name='cntrctCorpNm${i}' value='${result['response']['body']['items'][i]['cntrctCorpNm']}'>`);
                            $("#sendform").append("<input type='hidden' name='prdctSpecNm" + i + "' value='" + result['response']['body']['items'][i]['prdctSpecNm'] +"'>");
                            $("#sendform").append("<input type='hidden' name='cntrctPrceAmt" + i + "' value='" + result['response']['body']['items'][i]['cntrctPrceAmt'] +"'>");
                            $("#sendform").append("<input type='hidden' name='prdctOrgplceNm" + i + "' value='" + result['response']['body']['items'][i]['prdctOrgplceNm'] +"'>");
                            $("#sendform").append("<input type='hidden' name='prdctMakrNm" + i + "' value='" + result['response']['body']['items'][i]['prdctMakrNm'] +"'>");
                        }
    
                        $("#sendform").append("<input type='hidden' name='name' value='" + name + "'>");
                        $("#sendform").append("<input type='hidden' name='page' value='" + page + "'>");
                        $("#sendform").append("<input type='hidden' name='year' value='" + year + "'>");
                        $("#sendform").append("<input type='hidden' name='sendcnt' value='" + i + "'>");
    
                        let pageNum = Math.ceil(totalcnt / result['response']['body']['numOfRows']);
    
                        $(".cs_page").append("검색 결과 " + totalcnt + "개 &nbsp;&nbsp;&nbsp;&nbsp;");
                        $(".cs_page").append("<select id='pageselect'>");
    
                        for (let p = 1; p <= pageNum; p++) 
                        {
                            let act = "";
                            if(p == page) act = "selected";
                            $("#pageselect").append("<option data_idx='" + p + "' " + act + ">" + p + "</option>");
                        }
    
                        $(".cs_page").append("&nbsp;&nbsp;&nbsp;페이지");
                        $(".cs_page").append("<div class='cs_search' id='id_page' style='width:100px;'>페이지 전환</div>");
                    }
                    else
                    {
                        alert("검색 결과가 없습니다.");    
                    }
                }
                else
                {
                    alert("검색 결과가 없습니다.");
                }
            }
        },
        error:function(request,status,error)
        {
            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
        }
    });
}