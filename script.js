// Demo username
const username = "Sahid Molla";

document.getElementById("username").innerText = username;

// Menu click actions
document.querySelectorAll(".item").forEach(item => {
    item.addEventListener("click", () => {
        const name = item.innerText.trim();

        switch (name) {
            case "New Order":
                alert("New Order page will be added next.");
                break;

            case "Services":
                alert("Services page will be added next.");
                break;

            case "History":
                alert("Order History page will be added next.");
                break;

            case "Add Funds":
                alert("Add Funds page will be added next.");
                break;

            case "Profile":
                alert("Profile page will be added next.");
                break;

            case "Support":
                alert("Support page will be added next.");
                break;
        }
    });
});
