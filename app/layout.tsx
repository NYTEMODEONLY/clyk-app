import './globals.css'
import type { Metadata } from 'next'
import { Inter } from 'next/font/google'
import { Providers } from './providers'
import { Navbar } from '@/components/navbar'
import { Toaster } from 'sonner'

const inter = Inter({ subsets: ['latin'] })

export const metadata: Metadata = {
  title: 'Clyk - URL Shortener & QR Code Generator',
  description: 'Shorten URLs and generate QR codes with detailed analytics. The simple, fast, and free URL shortener.',
  keywords: 'URL shortener, QR code generator, link analytics, short links',
}

export default function RootLayout({
  children,
}: {
  children: React.ReactNode
}) {
  return (
    <html lang="en">
      <body className={inter.className}>
        <Providers>
          <div className="min-h-screen bg-background flex flex-col">
            <Navbar />
            <main className="flex-1 container mx-auto px-4 py-4 sm:py-6 max-w-6xl">
              <div className="min-h-full">
                {children}
              </div>
            </main>
          </div>
          <Toaster 
            position="top-center"
            expand={false}
            richColors
          />
        </Providers>
      </body>
    </html>
  )
}