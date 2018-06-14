//callback
function sum(a, b, callback){
    var sum = a + b;
    console.log('Sum is : ' + sum);
    if(typeof callback !== 'undefined') {
        callback(a,b);
    }
}
sum(1,2, function(a, b){
    alert('Param is ' + a + '&' + b);
});

//prototype
var Person = function(name){
    this.name = name;
}
Person.prototype.age = 20;
Person.prototype.gender = 'male';
Person.prototype.say = function(){
    alert('My name is ' + this.name);
};
var a = new Person('cong');
a.say();
console.log(a.age);
//-------------
//$.fn là viết tắt của prototype trong jquery