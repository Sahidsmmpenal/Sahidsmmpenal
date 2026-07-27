// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.0.0/firebase-app.js";
import { getAuth } from "https://www.gstatic.com/firebasejs/10.0.0/firebase-auth.js";
import { getAnalytics } from "https://www.gstatic.com/firebasejs/10.0.0/firebase-analytics.js";

// Your web app's Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyBELsMTiY8OqZE5zJqwUThrfUCSu13gG7U",
  authDomain: "sahidsmmpenal.firebaseapp.com",
  projectId: "sahidsmmpenal",
  storageBucket: "sahidsmmpenal.firebasestorage.app",
  messagingSenderId: "278872394021",
  appId: "1:278872394021:web:0309da42a62c36195472cc",
  measurementId: "G-B17NWVEBP3"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
export const auth = getAuth(app);
export const analytics = getAnalytics(app);
