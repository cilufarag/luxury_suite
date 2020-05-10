window.onload = function() {
	addItemsToRulesContainer();
};
  
function addItemsToRulesContainer() {

	const rulesContainer = document.getElementById("rules-container");

	for (item of rulesData) {
		const rulesItems = createRulesItems(item);
		rulesContainer.innerHTML += rulesItems;
	}
}

function createRulesItems(item) {
    
    return`

        <div class="col-lg-3 col-md-3 my-4" onclick="displayMessage('Rule Selected: ${item.rule}')">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <img src="img/home/${item.img}" class="card-img-top" alt="Food Not Allowed Sign">
                    <h4 class="card-title text-center">${item.rule}</h4>
                    <p class="card-text text-center">${item.desc}</p>
                </div>
            </div>
        </div>
    `;
};

function displayMessage(message){
    alert(message);
};
  
// JSON DATA

const rulesData = [
    {
        img: "rule1.svg",
        rule: "Primary Rule",
        desc: "NO WAY you cross this!"
    },
    {
        img: "rule2.svg",
        rule: "Also Important",
        desc: "You cross it, we kick you out."
    },
    {
        img: "rule3.svg",
        rule: "Bad Dogs",
        desc: "Bad Dogs DISALLOWED."
    },
    {
        img: "rule4.svg",
        rule: "No Smoking",
        desc: "Smoking is bad for your health."
    }
];
