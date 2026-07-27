import { initializeApp } from "https://www.gstatic.com/firebasejs/12.0.0/firebase-app.js";

import {
  getAuth,
  createUserWithEmailAndPassword,
  GoogleAuthProvider,
  signInWithPopup
} from "https://www.gstatic.com/firebasejs/12.0.0/firebase-auth.js";

import {
  getFirestore,
  doc,
  setDoc
} from "https://www.gstatic.com/firebasejs/12.0.0/firebase-firestore.js";
const firebaseConfig = {
  apiKey: "AIzaSyBELsMTiY8OqZE5zJqwUThrfUCSu13gG7U",
  authDomain: "sahidsmmpenal.firebaseapp.com",
  projectId: "sahidsmmpenal",
  storageBucket: "sahidsmmpenal.firebasestorage.app",
  messagingSenderId: "278872394021",
  appId: "1:278872394021:web:0309da42a62c36195472cc",
  measurementId: "G-B17NWVEBP3"
};

const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
const db = getFirestore(app);
const provider = new GoogleAuthProvider();

const signupBtn = document.getElementById("signupBtn");
const googleLogin = document.getElementById("googleLogin");

const name = document.getElementById("name");
const email = document.getElementById("email");
const password = document.getElementById("password");
signupBtn.addEventListener("click", async () => {

  if (
    name.value.trim() === "" ||
    email.value.trim() === "" ||
    password.value.trim() === ""
  ) {
    alert("Please fill all fields.");
    return;
  }

  try {

    const userCredential = await createUserWithEmailAndPassword(
      auth,
      email.value,
      password.value
    );

    const user = userCredential.user;

    const username =
      name.value.trim().toLowerCase().replace(/\s+/g, "") +
      Math.floor(Math.random() * 9000 + 1000);

    await setDoc(doc(db, "users", user.uid), {
      uid: user.uid,
      name: name.value,
      email: email.value,
      username: username,
      balance: 0,
      createdAt: new Date().toISOString()
    });

    alert("Account created successfully!");

    window.location.href = "home.html";

  } catch (error) {

    alert(error.message);

  }

});

googleLogin.addEventListener("click", async () => {
  try {

    const result = await signInWithPopup(auth, provider);
    const user = result.user;

    const username =
      (user.displayName || "user")
        .toLowerCase()
        .replace(/\s+/g, "") +
      Math.floor(Math.random() * 9000 + 1000);

    await setDoc(doc(db, "users", user.uid), {
      uid: user.uid,
      name: user.displayName || "",
      email: user.email || "",
      username: username,
      balance: 0,
      photoURL: user.photoURL || "",
      createdAt: new Date().toISOString()
    }, { merge: true });

    window.location.href = "home.html";

  } catch (error) {
    alert(error.message);
    console.error(error);
  }
});
