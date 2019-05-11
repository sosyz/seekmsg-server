function AES_encrypt(data, AesKey, CBCIV) {
    var key = CryptoJS.enc.Utf8.parse(AesKey);
    var ciphertext = CryptoJS.AES.encrypt(
        CryptoJS.enc.Base64.stringify(CryptoJS.enc.Utf8.parse(data)), 
        key, 
        {
            iv: CryptoJS.enc.Hex.parse(CBCIV),
            mode: CryptoJS.mode.CBC,
            padding:CryptoJS.pad.Pkcs7
        });
    
        return ciphertext.toString();
}

function AES_decrypt(data, AesKey, CBCIV) {
    var key = CryptoJS.enc.Utf8.parse(AesKey);
    var decrypted = CryptoJS.AES.decrypt(data,key,{
        iv: CryptoJS.enc.Hex.parse(CBCIV),
        mode: CryptoJS.mode.CBC,
        padding:CryptoJS.pad.Pkcs7
        });
    return CryptoJS.enc.Base64.parse(decrypted.toString(CryptoJS.enc.Utf8)).toString(CryptoJS.enc.Utf8);
}

window.onload = function () {
    var pwdkey = window.location.hash;
    pwdkey = pwdkey.substr(1, pwdkey.length);
    if (pwdkey == '') {
        document.getElementById('msgList').innerHTML = '<h3>来着何人？！</h3><!--password not found-->'
    } else {
        var html = "";
        var index = "";
        pwdkey = decodeURIComponent(pwdkey);
        var key = pwdkey.substr(0, 16);
        var iv = pwdkey.substr(16, pwdkey.length);
        var data = AES_decrypt(document.getElementById('msgList').getAttribute('data'), key, iv);
        if (data != '') {
            console.log(data);
            obj = JSON.parse(data);
            for (var i = obj.data.length - 1; i >= 0; i--) {
                msg = '';
                index = i;
                console.log(index);
                msg ='<div class="';
                if (obj.data[index].type > 0 && obj.data[index].type < 3){
                    msg += obj.data[index].type == 1 ? 'cleft' : 'cright';
                    msg += ' cmsg"><img class="headIcon radius" ondragstart="return false;" oncontextmenu="return false;" src="';
                    msg += obj.data[index].qq == 80000000 ? './img/anonymous.jpg' : 'https://q1.qlogo.cn/g?b=qq&nk=' + obj.data[index].qq + '&s=3';
                    msg += '"><span class="name">' + obj.data[index].name + '</span><span class="content">' + obj.data[index].msg + '</span></div>';
                }else if(obj.data[index].type == 3){
                    msg += obj.data[index].class + '"><span>' + obj.data[index].msg + '</span></div>';
                }
                html += msg
            }
            html += '<div class="powered tips"><span>This page was generated by <a href="https://github.com/MorFansLab/LiteWebChat_Frame">LiteWebChat_Frame</a><span class="pipe">•</span><a href="https://cqp.cc">SeekMsg</a> is maintained by <a href="https://sonui.cn">Sonui</a></span></div>';
        } else {
            document.getElementById('msgList').innerHTML = '<h3>你在试探什么？</h3><!--password error-->'
        }
        document.getElementById('msgList').innerHTML = html
    }
}