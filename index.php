<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>
<style>
body {
  margin: 0;
  height: 100vh;
  background: 
    repeating-linear-gradient(
      to right,
      rgba(0, 0, 0, 0.3),
      rgba(0, 0, 0, 0.3),
      rgba(255, 255, 255, 0.05),
      rgba(255, 255, 255, 0.05)
    ),
    linear-gradient(to right, #0b0b10, #2b2c2f, #3d3e41);
  background-blend-mode: overlay;
  box-shadow: inset 0 0 150px rgba(0, 0, 0, 0.6);
  color: white;
  font-family: 'Poppins', sans-serif;
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;
}

/*  Canvas stays behind all content */
#plexus-bg {
  position: fixed;
  top: 0;
  left: 0;
  z-index: -1;
  width: 100%;
  height: 100%;
  background: transparent;
}

/*  Original design unchanged */
.container {
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(201, 213, 215, 0.21);
  border-radius: 50px;
  box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
  backdrop-filter: blur(4px);
  -webkit-backdrop-filter: blur(4px);
  border: 1px solid rgba(201, 213, 215, 0.48);
  padding: 40px 60px;
  width: 700px;
  color: white;
}

.title-section {
  margin-top: 30px;
  padding: 10px;
  flex: 1;
  text-align: center;
  justify-content: center;
  font-size: 50px;
  font-weight: 600;
  border-right: 1px solid rgba(255, 255, 255, 0.3);
  height: 250px;
  padding-right: 40px;
}

.bar { color:red; }
.inv { margin: 0; font-size: 60px; }

.login-container {
  flex: 1;
  padding-left: 40px;
  text-align: center;
}

.login-container input[type="text"],
.login-container input[type="password"] {
  width: 100%;
  padding: 12px;
  margin: 10px 0;
  border: none;
  border-radius: 8px;
  outline: none;
  font-size: 15px;
  background: rgba(255, 255, 255, 0.2);
  color: #fff;
  transition: 0.3s;
}

.login-container input::placeholder {
  color: rgba(255, 255, 255, 0.7);
}

.login-container input:focus {
  background: rgba(255, 255, 255, 0.3);
  transform: scale(1.02);
}

.login-container button {
  width: 100%;
  padding: 12px;
  margin-top: 15px;
  background: #ffffff;
  color: #2575fc;
  border: none;
  border-radius: 10px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: 0.3s;
}

.login-container button:hover {
  background: #2575fc;
  color: #fff;
}

.login-container p {
  margin-top: 15px;
  font-size: 14px;
  color: rgba(255, 255, 255, 0.8);
}

.login-container p a {
  color: #fff;
  text-decoration: none;
  font-weight: 600;
}

.login-container p a:hover {
  text-decoration: underline;
}

.image-icon {
  display: flex;
  justify-content: center;
  margin-bottom: 15px;
}

.image-icon img {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  border: 3px solid rgba(255, 255, 255, 0.5);
  box-shadow: 0 0 15px rgba(255, 255, 255, 0.3);
  object-fit: cover;
}
</style>
</head>
<body>
  <!--  Added Plexus Background Canvas -->
  <canvas id="plexus-bg"></canvas>

  <form action="login.php" method="POST">
    <div class="container">
      <div class="title-section">
        <label class="bar">Barcode</label>
        <label class="inv">Inventory</label>
        <label class="sys">System</label>
      </div>

      <div class="login-container">
        <div class="image-icon">
          <img src="image/Me.jpg" alt="User Picture">
        </div>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Sign In</button>
        <p>Don't have an account? <a href="signup.php">Sign up</a></p>
      </div>
    </div>
  </form>

  <!--  Plexus JS Animation (interactive) -->
  <script>
  const canvas = document.getElementById('plexus-bg');
  const ctx = canvas.getContext('2d');
  let w, h;
  function resize() {
    w = canvas.width = window.innerWidth;
    h = canvas.height = window.innerHeight;
  }
  window.addEventListener('resize', resize);
  resize();

  const dots = [];
  const numDots = 80;
  const repelRadius = 120;
  const repelStrength = 0.2;

  let mouse = { x: null, y: null };

  window.addEventListener('mousemove', e => {
    mouse.x = e.clientX;
    mouse.y = e.clientY;
  });

  window.addEventListener('mouseleave', () => {
    mouse.x = null;
    mouse.y = null;
  });

  for (let i = 0; i < numDots; i++) {
    dots.push({
      x: Math.random() * w,
      y: Math.random() * h,
      vx: (Math.random() - 0.5) * 0.6,
      vy: (Math.random() - 0.5) * 0.6
    });
  }

  function animate() {
    ctx.clearRect(0, 0, w, h);

    for (let i = 0; i < numDots; i++) {
      const d = dots[i];

      // Repel effect near cursor
      if (mouse.x && mouse.y) {
        const dx = d.x - mouse.x;
        const dy = d.y - mouse.y;
        const dist = Math.sqrt(dx * dx + dy * dy);

        if (dist < repelRadius) {
          const force = (1 - dist / repelRadius) * repelStrength;
          d.vx += (dx / dist) * force;
          d.vy += (dy / dist) * force;
        }
      }

      d.x += d.vx;
      d.y += d.vy;

      // Keep inside screen
      if (d.x < 0 || d.x > w) d.vx *= -1;
      if (d.y < 0 || d.y > h) d.vy *= -1;

      ctx.beginPath();
      ctx.arc(d.x, d.y, 2, 0, Math.PI * 2);
      ctx.fillStyle = "rgba(255,255,255,0.8)";
      ctx.fill();
    }

    // Draw lines between nearby dots
    for (let i = 0; i < numDots; i++) {
      for (let j = i + 1; j < numDots; j++) {
        const dx = dots[i].x - dots[j].x;
        const dy = dots[i].y - dots[j].y;
        const dist = Math.sqrt(dx * dx + dy * dy);
        if (dist < 120) {
          ctx.beginPath();
          ctx.moveTo(dots[i].x, dots[i].y);
          ctx.lineTo(dots[j].x, dots[j].y);
          ctx.strokeStyle = "rgba(255,255,255," + (1 - dist / 120) * 0.3 + ")";
          ctx.lineWidth = 1;
          ctx.stroke();
        }
      }
    }

    requestAnimationFrame(animate);
  }

  animate();
  </script>
</body>
</html>
