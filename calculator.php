<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Smart Calculator</title>
  <style>
    body {
      background-color: #222;
      color: #fff;
      font-family: Arial, sans-serif;
      text-align: center;
      padding-top: 40px;
    }

    form {
      display: inline-block;
      background: #333;
      padding: 30px 40px;
      border-radius: 15px;
      box-shadow: 0px 8px 20px rgba(0,0,0,0.5);
    }

    .button {
      width: 50px;
      height: 40px;
      margin: 5px;
      font-size: 24px;
      border: none;
      border-radius: 8px;
      background-color: #444;
      color: white;
      cursor: pointer;
    }

    .button:hover {
      background-color: #0f9d58;
    }

    #clear, #equals {
      width: 80px;
    }

    #clear {
      background-color: #d32f2f;
    }

    #clear:hover {
      background-color: #b71c1c;
    }

    #equals {
      background-color: #0f9d58;
    }

    #equals:hover {
      background-color: #0c7c45;
    }

    #display {
      width: 300px;
      height: 40px;
      font-size: 32px;
      text-align: right;
      background-color: #111;
      color: #0f0;
      border-radius: 10px;
      padding: 15px;
      margin: 0 auto 20px;
      box-shadow: inset 0 0 10px #0f0;
      overflow-x: auto;
    }

    .container {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 10px;
      margin-top: 20px;
    }
  </style>
</head>
<body>

<form onsubmit="return false;">
  <div id="display">0</div>

  <div class="container">
    <button type="button" onclick="addNumber('7')" class="button">7</button>
    <button type="button" onclick="addNumber('8')" class="button">8</button>
    <button type="button" onclick="addNumber('9')" class="button">9</button>
    <button type="button" onclick="setOperator('/')" class="button">/</button>

    <button type="button" onclick="addNumber('4')" class="button">4</button>
    <button type="button" onclick="addNumber('5')" class="button">5</button>
    <button type="button" onclick="addNumber('6')" class="button">6</button>
    <button type="button" onclick="setOperator('x')" class="button">x</button>

    <button type="button" onclick="addNumber('1')" class="button">1</button>
    <button type="button" onclick="addNumber('2')" class="button">2</button>
    <button type="button" onclick="addNumber('3')" class="button">3</button>
    <button type="button" onclick="setOperator('-')" class="button">-</button>

    <button type="button" onclick="addNumber('0')" class="button">0</button>
    <button type="button" onclick="addDecimal()" class="button">.</button>
    <button type="button" onclick="toggleNegative()" class="button">+/-</button>
    <button type="button" onclick="setOperator('+')" class="button">+</button>

    <button type="button" onclick="setOperator('%')" class="button">%</button>
    <button type="button" onclick="deleteOne()" class="button">←</button>
    <button type="button" onclick="calculate()" id="equals" class="button">=</button>
    <button type="button" onclick="clearCalculator()" id="clear" class="button">C</button>
  </div>
</form>

<script>
  let displayValue = "";
  const display = document.getElementById('display');

  function updateDisplay() {
    display.innerText = displayValue || "0";
  }

  function addNumber(num) {
    displayValue += num;
    updateDisplay();
  }

  function setOperator(op) {
    if (displayValue !== "") {
      const lastChar = displayValue.slice(-1);
      if (!"+-x/%".includes(lastChar)) {
        displayValue += op;
        updateDisplay();
      }
    }
  }

  function calculate() {
    try {
      let expression = displayValue.replace(/x/g, '*');
      let result = eval(expression);
      displayValue = result.toString();
      updateDisplay();
    } catch {
      displayValue = "";
      display.innerText = "ERROR";
    }
  }

  function clearCalculator() {
    displayValue = "";
    updateDisplay();
  }

  function deleteOne() {
    displayValue = displayValue.slice(0, -1);
    updateDisplay();
  }

  function toggleNegative() {
    let match = displayValue.match(/(-?\d+\.?\d*)$/);
    if (match) {
      let num = match[1];
      let negated = num.startsWith("-") ? num.slice(1) : "-" + num;
      displayValue = displayValue.replace(/(-?\d+\.?\d*)$/, negated);
    } else if (displayValue === "") {
      displayValue = "-";
    }
    updateDisplay();
  }

  function addDecimal() {
    let parts = displayValue.split(/[\+\-\x\/%]/);
    let last = parts[parts.length - 1];
    if (!last.includes('.')) {
      displayValue += ".";
      updateDisplay();
    }
  }

  // Keyboard support
  document.addEventListener("keydown", (e) => {
    const key = e.key;
    if (!isNaN(key)) addNumber(key);
    else if (["+", "-", "/", "%"].includes(key)) setOperator(key);
    else if (key === "*") setOperator('x');
    else if (key === "Enter") calculate();
    else if (key === "Backspace") deleteOne();
    else if (key === ".") addDecimal();
  });
</script>

</body>
</html>
