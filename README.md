# 🛒 EZbuy – AI-Driven E-commerce & Blog Platform

**EZbuy** is a feature-rich e-commerce platform built using **Laravel (PHP)** and enhanced with **AI-powered tools** including a **LangChain + ChatGPT chatbot**, blog system, newsletter reminders, and more. It’s designed to deliver a seamless shopping and reading experience with both **commerce and content** at its core.

---

## 📺 Demo

Watch the full walkthrough here:  
[![EZbuy Demo](https://img.youtube.com/vi/Tz6RAk31pl0/0.jpg)](https://www.youtube.com/watch?v=Tz6RAk31pl0)

🔗 https://www.youtube.com/watch?v=Tz6RAk31pl0

---

## 🧩 Core Features

- 🖼️ Visual search using PyTorch + TensorFlow  
- 🛒 Add to cart and checkout functionality  
- 🛍️ Product listing with categorization, search, filtering 
- ✍️ Blog section with comment support  
- 📧 Newsletter system with **email reminders**  
- 🤖 AI-powered chatbot using **LangChain + ChatGPT** and Dialogflow 
- 🧠 Intelligent product recommendation assistant  
- 📊 Admin panel for product, blog, and user management  

---

## 🛠️ Technologies Used

- **Laravel (PHP)** – Backend & routing  
- **Python** – Used for LangChain AI chatbot integration  
- **LangChain + OpenAI GPT API** – AI customer assistant  
- **JavaScript, HTML, CSS** – Frontend interactions  
- **MySQL** – Database  
- **Zapier** – Newsletter & email system  
- **Figma** – UI design mockups  
- **GitHub + VS Code** – Dev environment  

---

## 🧑‍💻 My Role

As part of a 3-member team, I was responsible for:

- Frontend UI design using bootstrap   
- Full chatbot integration using Python + LangChain + ChatGPT  
- Blog and newsletter modules with backend logic  
- API routes and integration of dynamic components  
- Designing DB schema for products, blogs, users, and reminders  
- Ensuring mobile responsiveness and user-friendly navigation  

---

## 🚀 Getting Started

### 📦 Backend (Laravel)

```bash
git clone https://github.com/vazsalvi/EZbuy.git
cd EZbuy

composer install
cp .env.example .env
php artisan key:generate

# Set DB credentials in .env, then:
php artisan migrate
php artisan serve

cd ai-bot
pip install -r requirements.txt
python chatbot.py

🔐 Environment Variables
Make sure to configure the following in your .env:

DB_DATABASE, DB_USERNAME, DB_PASSWORD

MAIL_USERNAME, MAIL_PASSWORD (for newsletters)

OPENAI_API_KEY (for ChatGPT chatbot)
```

🙋‍♂️ Contributions
Contributions, suggestions, and feedback are welcome!
Open issues or submit PRs if you'd like to collaborate.

👤 Author
Made with ❤️ by Salvi Vaz
