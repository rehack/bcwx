/* function random(_sum, _len, _min, _max) {

    // 参数验证
    if (_sum === undefined || _sum === 0) {
        throw new Error('_sum参数不能为空')
    }
    if (_len === undefined || _len === 0) {
        throw new Error('_len参数不能为空')
    }
    if (_min === undefined || _min === 0) {
        throw new Error('_min参数不能为空')
    }
    if (_max === undefined || _max === 0) {
        throw new Error('_max参数不能为空')
    }

    if (_sum / _len > _max) {
        throw new Error('最大值不能小于平均值')
    }
    if (_sum / _len === _max) {
        console.warn('数组元素将全部相同')
    }



    console.log(_sum, _len, _min, _max)
    let arr1 = [];


    for (let i = 0; i < _len; i++) {
        arr1.push(calculate())
    }

    function calculate() {
        let sumArr = 0;
        if (arr1.length == 0) {
            sumArr = 0
        } else if (arr1.length == 0) {
            sumArr = arr1[0]
        } else {
            sumArr = arr1.reduce((a, b) => {
                return (parseFloat(a) + parseFloat(b)).toFixed(2)
            })
        }
        let max2 = _sum - sumArr - (_len - arr1.length) * _min;
        let min2 = parseInt((_sum - sumArr) / (_len - arr1.length))
        if (max2 > _max) {
            max2 = _max
        }
        let returnNum;
        if (arr1.length < _len - 1) {
            returnNum = (Math.random() * (max2 - min2) + min2).toFixed(2);
        } else {
            returnNum = (_sum - sumArr).toFixed(2)
        }
        return returnNum;
    }
    // 打乱排序
    let arr2 = [];
    while (true) {
        if (arr1.length === 0) {
            break;
        }
        let re = arr1.splice(parseInt(Math.random() * (arr1.length)), 1)
        arr2.push(re[0])
    }
    for (let i = 0; i < arr1.length; i++) {
        let re = arr1.splice(parseInt(Math.random() * (arr1.length)), 1)
        arr2.push(re[0])
    }

    // 验证模块,可以注释掉
    let re = arr2.reduce((a, b) => {
        return (parseFloat(a) + parseFloat(b)).toFixed(2)
    })
    re = parseInt(re)
    console.log(`数组总和：${re}`)
    console.log(JSON.stringify(arr2))
    let str = '';
    let str2 = '';
    for(let k=0;k<arr2.length;k++){
        str+=arr2[k]+'+';
        str2+=arr2[k]+',';
    }
    console.log(str)
    console.log(str2)

    

    if (re !== _sum) {
        throw new Error('总和不对')
    }

    for (let i = 0; i < arr2.length; i++) {
        if (arr2[i] > _max) {
            throw new Error('超过最大值')
        }
    }
    // return arr2;
}
for (let i = 0; i < 1; i++) {
    random(1000, 50, 1.13, 90)
}
 */



//  v2


function random(_sum, _len, _min, _max) {

    // 参数验证
    if (_sum === undefined || _sum === 0) {
        throw new Error('_sum参数不能为空')
    }
    if (_len === undefined || _len === 0) {
        throw new Error('_len参数不能为空')
    }
    if (_min === undefined || _min === 0) {
        throw new Error('_min参数不能为空')
    }
    if (_max === undefined || _max === 0) {
        throw new Error('_max参数不能为空')
    }

    _sum = _sum * 100
    _max = _max * 100
    _min = _min * 100
    if (_sum / _len > _max) {
        throw new Error('最大值不能小于平均值')
    }
    if (_sum / _len === _max) {
        console.warn('数组元素将全部相同')
    }



    console.log(_sum, _len, _min, _max)
    let arr1 = [];


    for (let i = 0; i < _len; i++) {
        arr1.push(calculate())
    }

    function calculate() {
        let sumArr = 0;
        if (arr1.length == 0) {
            sumArr = 0
        } else if (arr1.length == 0) {
            sumArr = arr1[0]
        } else {
            sumArr = arr1.reduce((a, b) => {
                return a + b
            })
        }
        let max2 = _sum - sumArr - (_len - arr1.length) * _min;
        let min2 = parseInt((_sum - sumArr) / (_len - arr1.length))
        if (max2 > _max) {
            max2 = _max
        }
        if (arr1.length < _len - 1) {
            let re = parseInt(Math.random() * (max2 - min2) + min2);
            return re;
        } else {
            return _sum - sumArr
        }
    }
    // 打乱排序
    let arr2 = [];
    while (true) {
        if (arr1.length === 0) {
            break;
        }
        let re = arr1.splice(parseInt(Math.random() * (arr1.length)), 1)
        arr2.push(re[0])
    }
    for (let i = 0; i < arr1.length; i++) {
        let re = arr1.splice(parseInt(Math.random() * (arr1.length)), 1)
        arr2.push(re[0])
    }
    let arr3 = arr2.map(x => {
        return x / 100
    })
    console.log(JSON.stringify(arr3))
    return JSON.stringify(arr3);
}
// random(1800, 100, 1.36, 50)

// console.log(81.23+1.4+37.66+97.64+55.77+116.76+78.68+46.28+1.43+1.38+1.28+1.44+2.61+1.41+1.6+1.37+130.74+66.52+1.43+51.48+63.12+97.05+1.31+1.42+12.56+82.67+67.31+1.35+127.44+69.02+130.37+80.53+42.65+1.3+85.05+117.58+1.07+131.38+12.74+1.45+1.52+1.36+124.94+112.22+1.41+115.88+1.48+33.18+1.16+1.37)

var a1 = [19.61,19.74,38.04,11.43,48.22,1.31,1.37,27.67,42.77,31.84,38.99,38.12,1.35,1.4,1.35,14.66,1.43,47.38,32.26,1.36,32.03,28.1,3.05,1.35,48.34,1.36,1.41,1.33,1.32,30.17,1.29,1.38,1.38,16.51,1.34,32.76,1.35,26.22,22.37,1.38,1.37,47.59,3.6,45.23,1.74,37.29,47.17,41.26,1.43,19.3,1.37,33.63,49.53,24.97,1.34,1.29,23.35,42.2,1.44,25.65,1.3,45.42,20.15,16.47,1.84,26.65,40.72,1.28,1.34,30.61,1.36,24.69,1.4,32.51,47.85,1.33,1.49,1.39,1.4,11,1.42,3.32,48.91,1.26,39.09,44.78,43.8,2.52,1.37,1.39,22.43,1.36,18.45,1.44,19.1,35.2,31.48,1.39,39.9,5.7];

var a2=[19.61,19.74,38.04,11.43,48.22,1.31,1.37,27.67,42.77,31.84,38.99,38.12,1.35,1.4,1.35,14.66,1.43,47.38,32.26,1.36,32.03,28.1,3.05,1.35,48.34,1.36,1.41,1.33,1.32,30.17,1.29,1.38,1.38,16.51,1.34,32.76,1.35,26.22,22.37,1.38,1.37,47.59,3.6,45.23,1.74,37.29,47.17,41.26,1.43,19.3,1.37,33.63,49.53,24.97,1.34,1.29,23.35,42.2,1.44,25.65,1.3,45.42,20.15,16.47,1.84,26.65,40.72,1.28,1.34,30.61,1.36,24.69,1.4,32.51,47.85,1.33,1.49,1.39,1.4,11,1.42,3.32,48.91,1.26,39.09,44.78,43.8,2.52,1.37,1.39,22.43,1.36,18.45,1.44,19.1,35.2,31.48,1.39,39.9,5.7]

var summm = a2.reduce((a, b) => {
    return a + b
})


console.log(a2.length,summm)