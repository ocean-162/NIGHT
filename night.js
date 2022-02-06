var a = new Date();
var h = a.getHours();
var y = a.getFullYear();
var b = a.getMonth();
var c = a.getDay();
var m = b + 1;
var d = c - 1;
var se;  //创建变量，下面用switch来赋值，再输出

switch(h){
    case 0:
	case 1:
	case 2:
	case 3:
    case 4:
    case 5:
        se = "凌晨了，多注意休息。";  //switch语句只可为变量赋值，不能直接向页面输出！！！
        break;
    case 6:
    case 7:
    case 8:
    case 9:
    case 10:
        se = "早上好！又是充满活力的一天！";
        break;
    case 11:
    case 12:
    case 13:
        se = "中午好。休息一下罢。";
        break;
    case 14:
    case 15:
    case 16:
    case 17:
        se = "下午好！继续努力罢。";
        break;
    case 18:
    case 19:
    case 20:
    case 21:
        se = "晚上好！放松一下罢。";
        break;
    case 22:
    case 23:
        se = "夜深了，快去睡罢。";
        break;
    default:
        se = "欢迎使用NIGHT起始页。";
};

//中央问候语输出
document.getElementById("timegreeting").innerHTML = se;
//左上角时间输出
document.getElementById("tip").innerHTML = "今天是：" + y + "年" + m + "月" + d + "日";