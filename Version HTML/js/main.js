calculate=function(){
    /*if (document.getElementById('height').value==NaN||document.getElementById('weight').value ==NaN||document.getElementById('age').value==NaN) {
        document.getElementById('result').value= 'Please fill all'
    }*/

    if (document.getElementById('height-unit').options[1].selected==true) {
        var height = document.getElementById('height').value;
    }else{
        var height =document.getElementById('height').value / 2.54;
    }

    if (document.getElementById('weight-unit').options[1].selected==true) {
        var weight = document.getElementById('weight').value;
    }else{
        var weight =document.getElementById('weight').value * 2.20462;
    }
    
    var age = document.getElementById('age').value;

    if (document.getElementById('male').checked) {
        var bmr = 66 + (6.24 * weight) + (12.7 * height) - (6.755 * age) ;
    } else if (document.getElementById('female').checked) {
        var bmr =655.1 + (4.35 * weight) + (4.7 * height) - (4.7 * age) ;
    }

    var activity = document.getElementsByTagName('select')[2].value;

    document.getElementById('result').value=Math.round( bmr * activity )+' Calories a day';
}