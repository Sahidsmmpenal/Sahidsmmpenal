import {
  auth,
  db,
  provider,
  signInWithPopup,
  signOut,
  onAuthStateChanged,
  doc,
  setDoc,
  getDoc
} from "./firebase.js";

// Google Login
const googleBtn = document.getElementById("googleLogin");

if (googleBtn) {
  googleBtn.addEventListener("click", async () => {
    try {
      const result = await signInWithPopup(auth, provider);

      const user = result.user;

      const userRef = doc(db, "users", user.uid);

      const snap = await getDoc(userRef);

      if (!snap.exists()) {
        await setDoc(userRef, {
          name: user.displayName || "",
          email: user.email || "",
          balance: 0,
          spent: 0,
          photo: user.photoURL || ""
        });
      }

      window.location.href = "home.html";

    } catch (e) {
      alert(e.message);
    }
  });
}
// Auto Login & Dashboard Data

onAuthStateChanged(auth, async (user) => {

  if (!user) return;

  const name = document.getElementById("userName");
  const email = document.getElementById("userEmail");
  const photo = document.getElementById("userPhoto");
  const balance = document.getElementById("balance");
  const spent = document.getElementById("spent");

  if (name) {
    name.innerText = user.displayName || user.email.split("@")[0];
  }

  if (email) {
    email.innerText = user.email;
  }

  if (photo && user.photoURL) {
    photo.src = user.photoURL;
  }

  const userRef = doc(db, "users", user.uid);
  const snap = await getDoc(userRef);

  if (snap.exists()) {
    const data = snap.data();

    if (balance) balance.innerText = "৳" + (data.balance || 0);

    if (spent) spent.innerText = "৳" + (data.spent || 0);
  }

});

// Logout

const logoutBtn = document.getElementById("logout");

if (logoutBtn) {

  logoutBtn.addEventListener("click", async () => {

    await signOut(auth);

    window.location.href = "signup.html";

  });

}
// Email Signup

const signupBtn = document.getElementById("signupBtn");

if (signupBtn) {

signupBtn.addEventListener("click", async () => {

const name = document.getElementById("name").value;

const email = document.getElementById("email").value;

const password = document.getElementById("password").value;

try {

const userCredential = await createUserWithEmailAndPassword(auth, email, password);

const user = userCredential.user;

await setDoc(doc(db, "users", user.uid), {

name: name,

email: email,

balance: 0,

spent: 0,

photo: ""

});

alert("Account Created Successfully!");

window.location.href = "home.html";

} catch (error) {

alert(error.message);

}

});

}
