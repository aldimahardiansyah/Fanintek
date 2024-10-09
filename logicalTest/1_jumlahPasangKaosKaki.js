function countSockPairs(arr) {
    const sockCount = {};

    arr.forEach(function (size) {
        if (sockCount[size]) {
            sockCount[size]++;
        } else {
            sockCount[size] = 1;
        }
    });

    let totalPairs = 0;
    for (const size in sockCount) {
        totalPairs += Math.floor(sockCount[size] / 2);
    }

    return totalPairs;
}

console.log(countSockPairs([10, 20, 20, 10, 10, 30, 50, 10, 20]));
console.log(countSockPairs([6, 5, 2, 3, 5, 2, 2, 1, 1, 5, 1, 3, 3, 3, 5]));
console.log(countSockPairs([1, 1, 3, 1, 2, 1, 3, 3, 3, 3]));
