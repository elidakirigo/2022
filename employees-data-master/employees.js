const employees = [
    {name : "jeremy", phone: 0720467320 , gender : "male"},
    {name : "sandra", phone: 0720467320,  gender : "female"},
    {name : "sussy", phone: 0720467320,  gender : "female"},
    {name : "kelvin", phone: 0720467320,  gender : "male"}
]
const td= document.querySelectorAll('td');
for (let i = 0; i < employees.length; i++) {
    for (let m = 0; m < td.length; m++) {
        for (const key in employees[m]) {
            console.log(key,employees[m][key]);
                td[i].innerHTML= employees[m][key];
        }
    }
}
