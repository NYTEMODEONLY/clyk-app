import { UrlShortener } from '@/components/url-shortener'
import { Separator } from '@/components/ui/separator'
import { Link, QrCode, BarChart3, Zap } from 'lucide-react'

export default function HomePage() {
  return (
    <div className="h-full flex flex-col">
      {/* Hero Section */}
      <div className="text-center space-y-4 py-6 flex-shrink-0">
        <div className="space-y-2">
          <h1 className="text-3xl sm:text-4xl md:text-5xl font-bold tracking-tight">
            Clyk
          </h1>
          <p className="text-lg sm:text-xl text-muted-foreground max-w-2xl mx-auto">
            The wildly easy URL shortener with QR codes and analytics
          </p>
        </div>
        
        <div className="flex flex-wrap justify-center gap-6 text-sm text-muted-foreground">
          <div className="flex items-center">
            <Zap className="mr-2 h-4 w-4" />
            <span>Instant shortening</span>
          </div>
          <div className="flex items-center">
            <QrCode className="mr-2 h-4 w-4" />
            <span>Auto QR codes</span>
          </div>
          <div className="flex items-center">
            <BarChart3 className="mr-2 h-4 w-4" />
            <span>Detailed analytics</span>
          </div>
          <div className="flex items-center">
            <Link className="mr-2 h-4 w-4" />
            <span>Custom aliases</span>
          </div>
        </div>
      </div>

      {/* Main URL Shortener */}
      <div className="flex-1 flex items-center justify-center px-4 min-h-0">
        <div className="w-full max-w-2xl">
          <UrlShortener />
        </div>
      </div>

      {/* Footer Features */}
      <div className="flex-shrink-0 py-6">
        <div className="grid grid-cols-1 sm:grid-cols-3 gap-6 text-center">
          <div className="space-y-3">
            <div className="w-12 h-12 bg-black text-white rounded-lg flex items-center justify-center mx-auto">
              <Link className="h-6 w-6" />
            </div>
            <h3 className="font-semibold">Smart Shortening</h3>
            <p className="text-muted-foreground text-sm leading-relaxed">
              Create short links instantly with optional custom aliases.
            </p>
          </div>

          <div className="space-y-3">
            <div className="w-12 h-12 bg-black text-white rounded-lg flex items-center justify-center mx-auto">
              <QrCode className="h-6 w-6" />
            </div>
            <h3 className="font-semibold">Instant QR Codes</h3>
            <p className="text-muted-foreground text-sm leading-relaxed">
              Every short link comes with a scannable QR code.
            </p>
          </div>

          <div className="space-y-3">
            <div className="w-12 h-12 bg-black text-white rounded-lg flex items-center justify-center mx-auto">
              <BarChart3 className="h-6 w-6" />
            </div>
            <h3 className="font-semibold">Rich Analytics</h3>
            <p className="text-muted-foreground text-sm leading-relaxed">
              Track clicks, referrers, devices, and geographic data.
            </p>
          </div>
        </div>

        <div className="text-center mt-8 space-y-2">
          <h2 className="text-xl font-bold">
            Ready to start shortening?
          </h2>
          <p className="text-muted-foreground text-sm max-w-md mx-auto">
            Sign in to save your links, access analytics, and manage your shortened URLs in one place.
          </p>
        </div>
      </div>
    </div>
  )
}