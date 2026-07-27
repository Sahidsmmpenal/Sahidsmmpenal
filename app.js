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
