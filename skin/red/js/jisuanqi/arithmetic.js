    var arithmetic = {
        /**贷款金额
         * 房屋总价 * 贷款成数
         */
        data_cs: [
            { id: '0', value: '九成', countVal: '0.9' },
            { id: '1', value: '八成', countVal: '0.8' },
            { id: '2', value: '七成', countVal: '0.7' },
            { id: '3', value: '六成', countVal: '0.6' },
            { id: '4', value: '五成', countVal: '0.5' },
            { id: '5', value: '四成', countVal: '0.4' },
            { id: '6', value: '三成', countVal: '0.3' },
            { id: '7', value: '二成', countVal: '0.2' }
        ],
        data_nx: [
            { id: '0', value: '1年', countVal: '1' },
            { id: '1', value: '2年', countVal: '2' },
            { id: '2', value: '3年', countVal: '3' },
            { id: '3', value: '4年', countVal: '4' },
            { id: '4', value: '5年', countVal: '5' },
            { id: '5', value: '6年', countVal: '6' },
            { id: '6', value: '7年', countVal: '7' },
            { id: '7', value: '8年', countVal: '8' },
            { id: '8', value: '9年', countVal: '9' },
            { id: '9', value: '10年', countVal: '10' },
            { id: '10', value: '11年', countVal: '11' },
            { id: '11', value: '12年', countVal: '12' },
            { id: '12', value: '13年', countVal: '13' },
            { id: '13', value: '14年', countVal: '14' },
            { id: '14', value: '15年', countVal: '15' },
            { id: '15', value: '16年', countVal: '16' },
            { id: '16', value: '17年', countVal: '17' },
            { id: '17', value: '18年', countVal: '18' },
            { id: '18', value: '19年', countVal: '19' },
            { id: '19', value: '20年', countVal: '20' },
            { id: '20', value: '21年', countVal: '21' },
            { id: '21', value: '22年', countVal: '22' },
            { id: '22', value: '23年', countVal: '23' },
            { id: '23', value: '24年', countVal: '24' },
            { id: '24', value: '25年', countVal: '25' },
            { id: '25', value: '26年', countVal: '26' },
            { id: '26', value: '27年', countVal: '27' },
            { id: '27', value: '28年', countVal: '28' },
            { id: '28', value: '29年', countVal: '29' },
            { id: '29', value: '30年', countVal: '30' }
        ],
        loansSum: function (housePrice, loansCs) {
            if (typeof (housePrice) != 'number') {
                housePrice = Number(housePrice);
            }
            if (typeof (loansCs) != 'number') {
                loansCs = Number(loansCs);
            }
            return housePrice * loansCs;
        },
        houseSum: function (housePrice, area) {
            if (typeof (housePrice) != 'number') {
                housePrice = Number(housePrice);
            }
            if (typeof (area) != 'number') {
                area = Number(area);
            }
            return housePrice * area / 10000;
        },
        lprSum: function (lpr, basePoint) {
            if (typeof (lpr) != 'number') {
                lpr = Number(lpr);
            }
            if (typeof (basePoint) != 'number') {
                basePoint = Number(basePoint);
            }
            
            return lpr + (basePoint/100);
        },
        average: function (loanAmount, permil, allPhase) {
            if (typeof (loanAmount) != 'number') {
                loanAmount = Number(loanAmount);
            }
            if (typeof (permil) != 'number') {
                permil = Number(permil);
            }
            if (typeof (allPhase) != 'number') {
                allPhase = Number(allPhase);
            }

            return (loanAmount * permil * Math.pow((1 + permil), allPhase)) / (Math.pow((1 + permil), allPhase) - 1)
        },
        averageArr: function (loanAmount, permil, allPhase) {
            var arr = [];
            if (typeof (loanAmount) != 'number') {
                loanAmount = Number(loanAmount);
            }
            if (typeof (permil) != 'number') {
                permil = Number(permil);
            }
            if (typeof (allPhase) != 'number') {
                allPhase = Number(allPhase);
            }
            for (var i = 1; i <= allPhase; i++) {
                var item = 0;
                item = loanAmount / allPhase + (loanAmount - (loanAmount / allPhase) * (i - 1))*permil;
                arr.push(item)
            }
            return arr
        }
    }
