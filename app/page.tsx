import { UrlShortener } from '@/components/url-shortener'
import { Separator } from '@/components/ui/separator'
import { Link, QrCode, BarChart3, Zap } from 'lucide-react'

export default function HomePage() {
  return (
    <div className="h-full flex flex-col">
      {/* Hero Section - More Compact */}
      <div className="text-center space-y-3 py-4 flex-shrink-0">
        <div className="space-y-2">
          <h1 className="text-2xl sm:text-3xl md:text-4xl font-bold tracking-tight">
            Clyk
          </h1>
          <p className="text-base sm:text-lg text-muted-foreground max-w-2xl mx-auto px-4">
            The wildly easy URL shortener with QR codes and analytics
          </p>
        </div>
        
        <div className="flex flex-wrap justify-center gap-3 sm:gap-4 text-xs sm:text-sm text-muted-foreground px-4">
          <div className="flex items-center">
            <Zap className="mr-1 h-3 w-3 sm:h-4 sm:w-4" />
            <span>Instant shortening</span>
          </div>
          <div className="flex items-center">
            <QrCode className="mr-1 h-3 w-3 sm:h-4 sm:w-4" />
            <span>Auto QR codes</span>
          </div>
          <div className="flex items-center">
            <BarChart3 className="mr-1 h-3 w-3 sm:h-4 sm:w-4" />
            <span>Detailed analytics</span>
          </div>
          <div className="flex items-center">
            <Link className="mr-1 h-3 w-3 sm:h-4 sm:w-4" />
            <span>Custom aliases</span>
          </div>
        </div>
      </div>

      {/* Main URL Shortener - Centered */}
      <div className="flex-1 flex items-center justify-center px-4 py-2 min-h-0">
        <div className="w-full max-w-2xl">
          <UrlShortener />
        </div>
      </div>

      {/* Footer Features - More Compact */}
      <div className="flex-shrink-0 py-4 px-4">
        <div className="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 text-center max-w-4xl mx-auto">
          <div className="space-y-2">
            <div className="w-8 h-8 sm:w-10 sm:h-10 bg-black text-white rounded-lg flex items-center justify-center mx-auto">
              <Link className="h-4 w-4 sm:h-5 sm:w-5" />
            </div>
            <h3 className="font-semibold text-sm">Smart Shortening</h3>
            <p className="text-muted-foreground text-xs leading-relaxed">
              Create short links instantly with optional custom aliases.
            </p>
          </div>

          <div className="space-y-2">
            <div className="w-8 h-8 sm:w-10 sm:h-10 bg-black text-white rounded-lg flex items-center justify-center mx-auto">
              <QrCode className="h-4 w-4 sm:h-5 sm:w-5" />
            </div>
            <h3 className="font-semibold text-sm">Instant QR Codes</h3>
            <p className="text-muted-foreground text-xs leading-relaxed">
              Every short link comes with a scannable QR code.
            </p>
          </div>

          <div className="space-y-2">
            <div className="w-8 h-8 sm:w-10 sm:h-10 bg-black text-white rounded-lg flex items-center justify-center mx-auto">
              <BarChart3 className="h-4 w-4 sm:h-5 sm:w-5" />
            </div>
            <h3 className="font-semibold text-sm">Rich Analytics</h3>
            <p className="text-muted-foreground text-xs leading-relaxed">
              Track clicks, referrers, devices, and geographic data.
            </p>
          </div>
        </div>

        <div className="text-center mt-4 space-y-2">
          <h2 className="text-lg font-bold">
            Ready to start shortening?
          </h2>
          <p className="text-muted-foreground text-xs max-w-md mx-auto">
            Sign in to save your links, access analytics, and manage your shortened URLs in one place.
          </p>
        </div>
      </div>
    </div>
  )
}