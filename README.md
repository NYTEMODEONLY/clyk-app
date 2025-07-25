# Clyk - URL Shortener & QR Code Generator (MVP)

A modern, minimalist URL shortener and QR code generator built with Next.js. This is a **Minimum Viable Product (MVP)** that runs entirely in the browser using local storage - no database or server setup required!

## ✨ Features

- **🔗 URL Shortening**: Create short links instantly with optional custom aliases
- **📱 QR Code Generation**: Automatic QR code creation for every short link
- **📊 Basic Analytics**: Track clicks, referrers, devices, and geographic data
- **🔐 Simple Authentication**: Demo sign-in system using local storage
- **📱 Responsive Design**: Works perfectly on desktop, tablet, and mobile
- **⚡ No Setup Required**: Everything runs in your browser - no database needed!

## 🚀 Quick Start

### Prerequisites

- Node.js 18+
- npm or yarn

### Installation

1. **Clone the repository**
   ```bash
   git clone <your-repo-url>
   cd clyk
   ```

2. **Install dependencies**
   ```bash
   npm install
   ```

3. **Run the development server**
   ```bash
   npm run dev
   ```

4. **Open your browser**
   Navigate to [http://localhost:3000](http://localhost:3000)

That's it! No database setup, no environment variables, no external services required.

## 🎯 MVP Features

### ✅ What's Included
- **URL Shortening**: Paste any URL and get a short link instantly
- **Custom Aliases**: Create memorable short links with your own text
- **QR Codes**: Every short link gets a downloadable QR code
- **Click Tracking**: See how many times your links are clicked
- **Basic Analytics**: View referrers, devices, countries, and browsers
- **Local Authentication**: Simple demo sign-in to save your links
- **Responsive UI**: Clean black/white design that works everywhere

### ⚠️ MVP Limitations
- **Local Storage Only**: Data is stored in your browser and cleared when you clear browser data
- **Single Device**: Links and analytics are only available on the device where you created them
- **Mock Location Data**: Geographic data is simulated based on your timezone
- **No Real Authentication**: The sign-in is just for demo purposes
- **Limited Title Fetching**: Uses a CORS proxy that may be unreliable

## 📱 How to Use

### 1. Shorten a URL
- Enter any URL in the main form
- Optionally add a custom alias
- Click "Shorten URL"
- Get your short link and QR code instantly!

### 2. Track Your Links
- Click "Sign In" and enter any name/email (demo only)
- Go to the Dashboard to see all your links
- Click "View Analytics" on any link to see detailed stats

### 3. Share Your Links
- Copy the short URL to share anywhere
- Download the QR code for print materials
- Track clicks in real-time on your dashboard

## 🏗️ Project Structure

```
clyk/
├── app/                    # Next.js App Router
│   ├── l/[shortCode]/     # Short link redirect pages
│   ├── dashboard/         # Analytics dashboard
│   ├── layout.tsx         # Root layout
│   ├── page.tsx          # Homepage
│   └── providers.tsx     # Auth provider
├── components/            # React components
│   ├── ui/               # shadcn/ui components
│   ├── auth-provider.tsx # Local auth system
│   ├── auth-dialog.tsx   # Sign-in modal
│   ├── url-shortener.tsx # Main shortening form
│   ├── qr-code-display.tsx # QR code generator
│   ├── analytics-dashboard.tsx # Analytics UI
│   └── navbar.tsx        # Navigation bar
├── lib/                  # Utilities
│   ├── local-storage.ts  # Local storage operations
│   ├── redirect-handler.ts # Click tracking
│   └── utils.ts          # Helper functions
└── public/               # Static assets
```

## 🛠️ Available Scripts

- `npm run dev` - Start development server
- `npm run build` - Build for production
- `npm run start` - Start production server
- `npm run lint` - Run ESLint

## 🎨 Customization

### Styling
- Update colors in `app/globals.css`
- Modify Tailwind config in `tailwind.config.ts`
- All components use shadcn/ui for consistent design

### Features
- Add new click tracking data in `lib/local-storage.ts`
- Enhance analytics in `components/analytics-dashboard.tsx`
- Modify the short code generation in `components/url-shortener.tsx`

### Branding
- Change the logo and app name in `components/navbar.tsx`
- Update the homepage content in `app/page.tsx`
- Modify the title and metadata in `app/layout.tsx`

## 📊 Data Storage

All data is stored locally in your browser using `localStorage`:

- **Links**: Your shortened URLs and their analytics
- **User Info**: Demo user profile (name, email, avatar)
- **Click Data**: Timestamps, referrers, device info, etc.

**Note**: This data will be lost if you:
- Clear your browser data
- Use incognito/private mode
- Switch browsers or devices

## 🚀 Production Deployment

### Vercel (Recommended)
1. Push to GitHub
2. Connect to Vercel
3. Deploy automatically - no configuration needed!

### Netlify
1. Push to GitHub
2. Connect to Netlify
3. Build command: `npm run build`
4. Publish directory: `out`

### Static Export
```bash
npm run build
# Upload the .next folder to any static hosting
```

## 🎯 Next Steps (Beyond MVP)

To turn this into a production app, consider:

1. **Real Database**: Add PostgreSQL/MySQL with Prisma
2. **Authentication**: Implement proper auth with NextAuth.js
3. **Analytics API**: Use real IP geolocation services
4. **Rate Limiting**: Prevent abuse
5. **Custom Domains**: Allow users to use their own domains
6. **Bulk Operations**: Import/export links
7. **Team Features**: Share links with teams
8. **Advanced Analytics**: More detailed insights

## 🤝 Contributing

This is an MVP/demo project, but contributions are welcome!

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📝 License

MIT License - feel free to use this for personal or commercial projects!

## 🙏 Acknowledgments

- [Next.js](https://nextjs.org/) - React framework
- [Tailwind CSS](https://tailwindcss.com/) - Styling
- [shadcn/ui](https://ui.shadcn.com/) - UI components
- [Lucide](https://lucide.dev/) - Icons
- [react-qr-code](https://github.com/rosskhanas/react-qr-code) - QR code generation

---

**Perfect for**: Learning React/Next.js, prototyping, demos, hackathons, or as a starting point for a full URL shortener service.

**Made with ❤️ for developers who want to build fast!** 

Start shortening URLs in under 5 minutes! 🚀