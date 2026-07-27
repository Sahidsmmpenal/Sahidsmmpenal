// SAHID SMM PANEL - App Script

import { initializeApp } from "https://www.gstatic.com/firebasejs/12.0.0/firebase-app.js";

import {
  getAuth,
  GoogleAuthProvider,
  createUserWithEmailAndPassword,
  signInWithPopup
} from "https://www.gstatic.com/firebasejs/12.0.0/firebase-auth.js";

import {
  getFirestore
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
